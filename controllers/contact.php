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
class Contact extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library(array('form_validation', 'security', 'session'));
    $this->load->database();
    $this->lang->load('idslot');
    $this->lang->load('tank_auth');
  }

  public function index() {
    $msg = '';
    $this->form_validation->set_rules('name', lang('Name'), 'trim|required|xss_clean');
    $this->form_validation->set_rules('email', lang('Email'), 'trim|required|xss_clean|valid_email');
    $this->form_validation->set_rules('message', lang('Message'), 'trim|required|xss_clean');
    $this->form_validation->set_rules('captcha', lang('Confirmation Code'), 'trim|xss_clean|required|callback_check_captcha');

    if ($this->form_validation->run()) {
      $this->load->library('tank_auth');
      $this->lang->load('tank_auth');
      $user = $this->users->get_user_by_id(1);
      $this->send_email($user->email, $this->input->post('name'), $this->input->post('email'), $this->input->post('message'));
      $msg = lang('Your message send.');
    } else {
      $this->form_validation->set_error_delimiters('', '');
      if (validation_errors()) {
        $msg = str_replace("\n", "\\n", validation_errors());
      }
    }
    $this->load->view('user/contact', array('msg' => '"' . $msg . '"'));
  }
  
  public function check_captcha($code) {
    $captcha = $this->session->userdata('captcha_code');
    $this->session->unset_userdata('captcha_code');
    if($code == $captcha){
      return true;
    }else{
      $this->form_validation->set_message('check_captcha', lang('auth_incorrect_captcha'));
      return false;
    }
  }

  private function send_email($to, $name, $from, $message) {
    $to = strip_tags($to);
    $from = strip_tags($from);
    $name = strip_tags($name);
    $this->load->library('email');
    $this->email->from($from, $name);
    $this->email->reply_to($from, $name);
    $this->email->to($to);
    $this->email->subject(lang('New message from your page'));
    $this->email->message(strip_tags($message));
    $this->email->send();
  }

}