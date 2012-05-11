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
 * IDSlot Controller
 **/
class Idslot extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('security');
    $this->load->library('tank_auth');
    $this->load->model('system');
    $this->system->choose_language();
    
    if (!$this->tank_auth->is_logged_in()) {
      redirect('auth/login');
    }
  }

  /**
   * Default method
   **/
  function index(){
    $plugins = $this->config->item('plugins');
    $plugin = array_shift($plugins);
    $this->edit($plugin);
  }
  
  /**
   * Stats method
   **/
  function statistics(){
    $data['plugins'] = $this->config->item('plugins');
    $this->load->model('system');
    $this->system->add_msg(lang('Under Construction'));
    
    $data['page_title'] = lang('Statistics');
    $this->load->view('user/index.tpl', $data);
  }
  
  /**
   * Settings method
   **/
  function settings(){
    $this->edit('settings');
  }
  
  /**
   * Details method
   **/
  function details(){
    $this->edit('details');
  }
  
  function feedback(){
    $this->edit('feedback');
  }
  
  function resume(){
    $this->edit('resume');
  }
  
  function inviter(){
    $this->edit('inviter');
  }
  
  function services(){
    $this->edit('services');
  }
  
  /**
   * Edit method
   **/
  function edit($plugin, $refresh=false){
    if (!$this->tank_auth->is_logged_in()) {
      redirect('auth/login');
    }
    
    $this->load->helper(array('form', 'url'));
    $this->load->library(array('session', 'form_validation'));
    $uid = $this->session->userdata('user_id');
    
    if($uid < 1){
      redirect('auth/login', 'location', 301);
      return;
    }
    
    $this->load->model('system');
    $this->load->model('plugins/' . $plugin);
    $config = $this->$plugin->form_rules();
    $this->form_validation->set_rules($config);

    if($this->form_validation->run() == TRUE){
      if($result = $this->$plugin->update($uid, $this->input->post($plugin))){
        if($sizes = $this->$plugin->image_size()){
          $this->system->upload_images($uid, $sizes);
        }
        $this->system->render($uid);
        
        $this->system->add_msg(sprintf(lang('x updated.'), lang(ucfirst($plugin))));
        if($refresh){
          redirect('idslot/edit/' . $plugin);
        }
      }else{
        $data['errors'][] = $result;
        $data['errors'][] = sprintf(lang('Error in updating x'), lang(ucfirst($plugin)));
      }
    } else {
      $this->form_validation->set_error_delimiters('','<br />');
      $data['errors'][] = validation_errors();
    }
    
    $data['plugins'] = $this->config->item('plugins');
    $data['plugin'] = $this->$plugin->fetch($uid);
    $data['page_title'] = ucfirst($plugin);
    
    $data['uid'] = $this->session->userdata('user_id');
    $user = $this->users->get_user_by_id($data['uid']);
    
    $data['username'] = $user->username;
    $data['domain'] = $user->domain;
    $data['language'] = $user->language;
    
    $this->load->view('user/index.tpl', $data);
  }

  function run($plugin, $command, $param=false){
    $this->load->model('plugins/' . $plugin);
    $this->$plugin->$command($param);
  }
  
  /**
   * Show info message
   *
   * @param	string
   * @return	void
   */
  function _show_message($message)
  {
    $this->session->set_flashdata('message', $message);
    redirect('auth/login');
  }
  
  function remove_img($plugin, $id=false){
    $uid = $this->session->userdata('user_id');
    $username = $this->session->userdata('username');
    $this->load->helper('file');
    $this->load->helper('path');
    $this->load->model('plugins/' . $plugin);
    $images = $this->$plugin->image_size();
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    $ids_path = "{$ids_path}/idslots/users/{$uid}-{$username}/";
    foreach($images as $prefix=>$size){
      if($id){
        $filename = $prefix . "{$uid}-{$id}.png";
      }else{
        $filename = $prefix . "{$uid}.png";
      }
      unlink($ids_path . "files/{$plugin}/{$filename}");
    }
    redirect($_SERVER['HTTP_REFERER']);
    exit();
  }
}
