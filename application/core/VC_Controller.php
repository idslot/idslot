<?php

class VC_Controller extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('security');
    $this->load->library('tank_auth');
    $this->load->model('system');
    $this->lang->load('tank_auth');
    $this->lang->load('idslot');
    $this->load->helper('language');
    if (!$this->tank_auth->is_logged_in()) {
      redirect('auth/login');
    }
  }
}
