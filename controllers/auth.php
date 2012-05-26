<?php
/**
 * IDSlot
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package	IDSlot
 * @author	IDSlot Development Team
 * @copyright	Copyright (c) 2012, IDSlot Development Team
 * @license	http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link	http://idslot.org
 */


if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    
    
    include(APPPATH . 'config/database.php');
    if ($db['default']['hostname'] == '') {
      redirect('install');
      exit();
    }
    
    $this->load->library('security');
    $this->load->library('tank_auth');
    $this->load->helper('language');
    $this->load->model('system');
    $this->system->choose_language();
    $this->lang->load('idslot');
    $this->lang->load('tank_auth');
  }

  public function index() {
    if ($message = $this->session->flashdata('message')) {
      $this->load->view('auth/general_message', array('message' => $message));
    } else {
      redirect('/auth/login/');
    }
  }

  public function login() {
    if ($this->tank_auth->is_logged_in()) { // logged in
      redirect('idslot');
    }

    // Get login for counting attempts to login
    if ($this->config->item('login_count_attempts', 'tank_auth') AND
            ($login = $this->input->post('login'))) {
      $login = $this->security->xss_clean($login);
    } else {
      $login = '';
    }

    $data['errors'] = array();

    // set login variables
    $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
            $this->config->item('use_username', 'tank_auth'));
    $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

    // set register variables
    $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
    $data['captcha_registration'] = $this->config->item('captcha_registration', 'tank_auth');

    if ($data['captcha_registration']) {
      if ($data['use_recaptcha']) {
        $data['recaptcha_html'] = $this->_create_recaptcha();
      } else {
        $data['captcha_html'] = $this->_create_captcha();
      }
    }

    $data['use_username'] = $this->config->item('use_username', 'tank_auth');

    $data['show_captcha'] = FALSE;
    if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
      $data['show_captcha'] = TRUE;
      if ($data['use_recaptcha']) {
        $data['recaptcha_html'] = $this->_create_recaptcha();
      } else {
        $data['captcha_html'] = $this->_create_captcha();
      }
    }

    if ($this->input->post('submit_login')) {
      $data['errors'] = $this->_login();
    } elseif ($this->input->post('submit_forgot')) {
      $data['errors'] = $this->_forgot_password();
    }

    $this->load->view('auth/login_form', $data);
  }

  /**
   * Login user on the site
   *
   * @return void
   */
  public function _login() {
    $data['errors'] = array();

    if ($this->tank_auth->is_logged_in(FALSE)) {
      redirect('/auth/send_again/');
    } else {
      // set login variables
      $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
              $this->config->item('use_username', 'tank_auth'));
      $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

      $this->form_validation->set_rules('login', lang('Login'), 'trim|required|specialchars|alpha_dash');
      $this->form_validation->set_rules('password', lang('Password'), 'trim|required|specialchars|alpha_dash');
      $this->form_validation->set_rules('remember', lang('Remember me'), 'integer');

      // Get login for counting attempts to login
      if ($this->config->item('login_count_attempts', 'tank_auth') AND
              ($login = $this->input->post('login'))) {
        $login = $this->security->xss_clean($login);
      } else {
        $login = '';
      }

      $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
      if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
        if ($data['use_recaptcha'])
          $this->form_validation->set_rules('recaptcha_response_field', lang('Confirmation Code'), 'trim|xss_clean|required|callback__check_recaptcha');
        else
          $this->form_validation->set_rules('captcha', lang('Confirmation Code'), 'trim|xss_clean|required|callback__check_captcha');
      }

      if ($this->form_validation->run()) {
        if ($this->tank_auth->login(
                        $this->form_validation->set_value('login'), $this->form_validation->set_value('password'), $this->form_validation->set_value('remember'), $data['login_by_username'], $data['login_by_email'])) {
          redirect('idslot');
        } else {
          $errors = $this->tank_auth->get_error_message();
          if (array_key_exists('banned', $errors)) {
            $data['errors'][] = lang('auth_message_banned');
          } elseif (array_key_exists('not_activated', $errors)) {
            redirect('/auth/send_again/');
          } else {
            foreach ($errors as $k => $v)
              $data['errors'][$k] = lang($v);
          }
        }
      } else {
        $this->form_validation->set_error_delimiters('','<br />');
        $data['errors'][] = validation_errors();
      }
    }
    return $data['errors'];
  }

  /**
   * Logout user
   *
   * @return void
   */
  public function logout() {
    $this->tank_auth->logout();
    redirect('auth/login');
  }


  /**
   * Generate reset code (to change password) and send it to user
   *
   * @return void
   */
  public function _forgot_password() {
    $data['errors'] = array();

    $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');

    if ($this->tank_auth->is_logged_in(FALSE)) {      // logged in, not activated
      redirect('/auth/send_again/');
    } else {
      if ($this->form_validation->run()) {        // validation ok
        if (!is_null($data = $this->tank_auth->forgot_password(
                                $this->form_validation->set_value('login')))) {
          $data['site_name'] = $this->config->item('website_name', 'tank_auth');
          // Send email with password activation link
          $this->_send_email('forgot_password', $data['email'], $data);
          $data['errors'][0] = $this->lang->line('auth_message_new_password_sent');
        } else {
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)
            $data['errors'][$k] = $this->lang->line($v);
        }
      } else {
        $this->form_validation->set_error_delimiters('','<br />');
        $data['errors'][0] = validation_errors();
      }
    }

    return $data['errors'];
  }

  /**
   * Replace user password (forgotten) with a new one (set by user).
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  public function reset_password() {
    $this->load->model('system');
    $user_id = $this->uri->segment(3);
    $new_pass_key = $this->uri->segment(4);

    $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
    $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

    $data['errors'] = array();

    if ($this->form_validation->run()) {        // validation ok
      if (!is_null($data = $this->tank_auth->reset_password(
                              $user_id, $new_pass_key, $this->form_validation->set_value('new_password')))) { // success
        $data['site_name'] = $this->config->item('website_name', 'tank_auth');

        // Send email with new password
        $this->_send_email('reset_password', $data['email'], $data);

        $this->system->add_msg($this->lang->line('auth_message_new_password_activated'));
        redirect('auth/login');
      } else {              // fail
        $this->system->add_msg($this->lang->line('auth_message_new_password_failed'));
      }
    } else {

      if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
        $this->_show_message($this->lang->line('auth_message_new_password_failed'));
      }
    }
    $this->load->view('auth/reset_password_form', $data);
  }

  /**
   * Change user password
   *
   * @return void
   */
  public function change_password() {
    if (!$this->tank_auth->is_logged_in()) {        // not logged in or not activated
      redirect('/auth/login/');
    } else {
      $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
      $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
      $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

      $data['errors'] = array();

      if ($this->form_validation->run()) {        // validation ok
        if ($this->tank_auth->change_password(
                        $this->form_validation->set_value('old_password'), $this->form_validation->set_value('new_password'))) { // success
          $this->_show_message($this->lang->line('auth_message_password_changed'));
        } else {              // fail
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)
            $data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->load->view('auth/change_password_form', $data);
    }
  }

  /**
   * Change user email
   *
   * @return void
   */
  public function change_email() {
    if (!$this->tank_auth->is_logged_in()) {        // not logged in or not activated
      redirect('/auth/login/');
    } else {
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

      $data['errors'] = array();

      if ($this->form_validation->run()) {        // validation ok
        if (!is_null($data = $this->tank_auth->set_new_email(
                                $this->form_validation->set_value('email'), $this->form_validation->set_value('password')))) {   // success
          $data['site_name'] = $this->config->item('website_name', 'tank_auth');

          // Send email with new email address and its activation link
          $this->_send_email('change_email', $data['new_email'], $data);

          $this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));
        } else {
          $errors = $this->tank_auth->get_error_message();
          foreach ($errors as $k => $v)
            $data['errors'][$k] = $this->lang->line($v);
        }
      }
      $this->load->view('auth/change_email_form', $data);
    }
  }

  /**
   * Replace user email with a new one.
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  public function reset_email() {
    $user_id = $this->uri->segment(3);
    $new_email_key = $this->uri->segment(4);

    // Reset email
    if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) { // success
      $this->tank_auth->logout();
      $this->_show_message($this->lang->line('auth_message_new_email_activated') . ' ' . anchor('/auth/login/', 'Login'));
    } else {                // fail
      $this->_show_message($this->lang->line('auth_message_new_email_failed'));
    }
  }

  /**
   * Show info message
   *
   * @param	string
   * @return	void
   */
  public function _show_message($message) {
    $this->session->set_flashdata('message', $message);
    redirect('/auth/');
  }

  /**
   * Send email message of given type (activate, forgot_password, etc.)
   *
   * @param	string
   * @param	string
   * @param	array
   * @return	void
   */
  public function _send_email($type, $email, &$data) {
    $this->load->library('email');
    $this->email->from('noreply@' . $this->config->item('base_url'), $this->config->item('website_name', 'tank_auth'));
    $this->email->reply_to('noreply@' . $this->config->item('base_url'), $this->config->item('website_name', 'tank_auth'));
    $this->email->to($email);
    $this->email->subject(sprintf($this->lang->line('auth_subject_' . $type), $this->config->item('website_name', 'tank_auth')));
    $this->email->message($this->load->view('email/' . $type . '-html', $data, TRUE));
    $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, TRUE));
    $this->email->send();
  }

  /**
   * Create CAPTCHA image to verify user as a human
   *
   * @return	string
   */
  public function _create_captcha() {
    $captcha_path = $this->config->item('base_url') . 'index.php?/captcha/generate';
    return "<img src='$captcha_path' border='0' />";
  }

  /**
   * Callback function. Check if CAPTCHA test is passed.
   *
   * @param	string
   * @return	bool
   */
  public function _check_captcha($code) {
    $captcha = $this->session->userdata('captcha_code');
    $this->session->unset_userdata('captcha_code');
    if($code == $captcha){
      return true;
    }else{
      $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
      return false;
    }
  }

  /**
   * Create reCAPTCHA JS and non-JS HTML to verify user as a human
   *
   * @return	string
   */
  public function _create_recaptcha() {
    $this->load->helper('recaptcha');

    // Add custom theme so we can get only image
    $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

    // Get reCAPTCHA JS and non-JS HTML
    $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

    return $options . $html;
  }

  /**
   * Callback function. Check if reCAPTCHA test is passed.
   *
   * @return	bool
   */
  public function _check_recaptcha() {
    $this->load->helper('recaptcha');

    $resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'), $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);

    if (!$resp->is_valid) {
      $this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
      return FALSE;
    }
    return TRUE;
  }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
