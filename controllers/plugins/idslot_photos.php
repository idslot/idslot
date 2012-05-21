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
class idslot_photos extends VC_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('system');
    $this->load->library('form_validation');
    $this->uid = $this->session->userdata('user_id');
    $this->load->model('plugins/photos');
    
    $this->load->helper('language');
    $this->lang->load('tank_auth');
    $this->lang->load('idslot');
  }
  
  public function add($pid){
    $config = $this->photos->row_form_rules();
    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == TRUE){
      if($id = $this->photos->add_row($pid, $this->input->post('content'))){
        if($sizes = $this->photos->image_size()){
          $this->system->upload_images($this->uid, $sizes, $id);
        }
        $this->system->render($this->uid);
        $this->system->add_msg(lang('Photos added.'));
      }else{
        $this->system->add_msg(lang('Error in add photos!'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in add photos!') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/photos');
  }

  public function edit($id){
    $config = $this->photos->row_form_rules();
    $this->form_validation->set_rules($config);
    if($this->form_validation->run() == TRUE){
      if($this->photos->edit_row($id, $this->input->post('content'))){
        if($sizes = $this->photos->image_size()){
          $this->system->upload_images($this->uid, $sizes, $id);
        }
        $this->system->render($this->uid);
        $this->system->add_msg(lang('Photos edited.'));
      }else{
        $this->system->add_msg(lang('Error in edit photos!'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in edit photos!') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/photos');
  }

  public function remove($id){
    if($this->photos->remove_row($id)){
      $this->system->render($this->uid);
      $this->system->add_msg(lang('Photos removed.'));
    }else{
      $this->system->add_msg(lang('Error in remove photos!'));
    }
    redirect('idslot/edit/photos');
  }
  
  public function sort(){
    $this->photos->sort($this->input->post('photos'));
    $this->system->render($this->uid);
  }
}
