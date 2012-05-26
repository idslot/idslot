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
/**
 * Settings model
 **/
class Settings_Model extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch user details
   *
   * @param  integer  User id
   * @return array    user
   **/
  public function fetch($uid){
    $this->load->database();
    $this->db->where('id', $uid);
    $query = $this->db->get('user');

    return $query->row_array();
  }

  /**
   * Edit detail of user to idslot
   *
   * @param  integer  User id
   * @param  array
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->load->database();
    $this->db->where('id', $uid);
    $this->load->library('tank_auth');
    $this->lang->load('tank_auth');
    if($arr['old_password'] && $arr['new_password'])
    {
      if($this->tank_auth->change_password($arr['old_password'], $arr['new_password'])){
        return true;
      } else {
        $errors = $this->tank_auth->get_error_message();
        foreach ($errors as $k => $v){
          $this->system->add_msg(lang($error));
        }
        return false;
      }
    }
    elseif ($arr['old_password'] && $arr['email'])
    {
      $this->tank_auth->change_email($arr['email'], $arr['old_password']);
      
      if (!is_null($data = $this->tank_auth->set_new_email($arr['email'], $arr['old_password']))) {   // success
         //$data['site_name'] = $this->config->item('website_name', 'tank_auth');
         //$this->_send_email('change_email', $data['new_email'], $data);
         $this->users->activate_new_email($uid, $data['new_email_key']);
         //$this->system->add_msg(sprintf(lang('auth_message_new_email_sent'), $data['new_email']));
         return true;
      } else {
        $errors = $this->tank_auth->get_error_message();
        foreach($errors as $error){
          $this->system->add_msg(lang($error));
        }
        return false;
      }
    }
    else
    {
      $this->system->add_msg(lang('Fill email or new password fields'));
      return false;
    }
  }

  /**
   * Form rules
   **/
  public function form_rules(){
    return array(
      array(
            'field'   => 'settings[email]',
            'label'   => lang('Email'),
            'rules'   => 'trim|xss_clean|valid_email'
          ),
      array(
            'field'   => 'settings[old_password]',
            'label'   => lang('Old Password'),
            'rules'   => 'required|trim|specialchars|alpha_dash'
          ),
      array(
            'field'   => 'settings[new_password]',
            'label'   => lang('New Password'),
            'rules'   => 'trim|matches[confirm_password]|specialchars|alpha_dash'
          ),
      array(
            'field'   => 'confirm_password',
            'label'   => lang('New Password Confirm'),
            'rules'   => 'trim|specialchars|alpha_dash'
          )
    );
  }
  
    
  /**
   * Return image size
   *
   * @param string  action
   * @return  array image sizes
   **/
  public function image_size($action=false){
    return false;
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
    $this->email->from('noreply@' . $_SERVER['HTTP_HOST'], $this->config->item('website_name', 'tank_auth'));
    $this->email->to($email);
    $this->email->subject(sprintf($this->lang->line('auth_subject_' . $type), $this->config->item('website_name', 'tank_auth')));
    $this->email->set_mailtype('html');
    $this->email->message($this->load->view('email/' . $type . '-html', $data, TRUE));
    $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, TRUE));
    $this->email->send();
  }
}
