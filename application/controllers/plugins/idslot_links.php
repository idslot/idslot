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
class idslot_links extends VC_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->uid = $this->session->userdata('user_id');
    $this->load->model('plugins/links');
    
    $this->load->helper('language');
    $this->lang->load('tank_auth');
    $this->lang->load('idslot');
  }
  
  public function add($sid){
    $config = $this->links->row_form_rules();
    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == TRUE){
      if($this->links->add_row($sid, $this->input->post('name'), $this->input->post('url'), $this->input->post('icon'))){
        $this->system->render($this->uid);
        $this->system->add_msg(lang('Link added.'));
      }else{
        $this->system->add_msg(lang('Error in add link!'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in add link!') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/links');
  }

  public function edit($id){
    $config = $this->links->row_form_rules();
    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == TRUE){
      if($this->links->edit_row($id, $this->input->post('name'), $this->input->post('url'), $this->input->post('icon'))){
        $this->system->render($this->uid);
        $this->system->add_msg(lang('Link edited.'));
      }else{
        $this->system->add_msg(lang('Error in edit link!'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in edit link!') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/links');
  }

  public function remove($id){
    if($this->links->remove_row($id)){
      $this->system->render($this->uid);
      $this->system->add_msg(lang('Link removed.'));
    }else{
      $this->system->add_msg(lang('Error in remove link!'));
    }
    redirect('idslot/edit/links');
  }
}
