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
class Resume_Controller extends IDS_Controller {
  
  private $rid; // Resume ID
  
  public function __construct(){
    parent::__construct();
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->model('plugin');
    $this->uid = $this->session->userdata('user_id');
    $this->plugin->model('resume');
    
    $this->load->helper('language');
    $this->lang->load('tank_auth');
    $this->lang->load('idslot');
    
    // load resume id
    $this->rid = $this->resume->fetch();
    $this->rid = $this->rid['id'];
  }
  
  public function suggest_skill(){
    $skill = $this->input->get('term');
    $skill = urldecode($skill);
    $skills = $this->resume->fetch_skills_like($skill);
    $count = count($skills);
    $i = 0;
    header('Content-Type: application/json; charset=UTF-8');
    
    // because of a big bug in stupid JQuery, we should generate it by our own.
    // but rememeber it has a lot of bugs in it!
    // and we MUST use json_encode!
    echo "[ ";
    foreach($skills as $skill){
      echo "{\"id\": \"skill\", \"label\": \"{$skill['title']}\", \"value\": \"{$skill['title']}\"} ";
      if(++$i < $count){
        echo ', ';
      }
    }
    echo " ]";
    //echo json_encode($skills);
    exit();
  }
  
  public function add_skill(){
    $rules = $this->resume->form_rules_skill();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      if($this->resume->add_skill($this->rid, $this->input->post('title'))){
        $this->system->add_msg(lang('Skill added'));
      }else{
        $this->system->add_msg(lang('Error in adding skill'));
      }
    } else {
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in adding skill') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function edit_skill($id){
    $rules = $this->resume->form_rules_skill();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      if($this->resume->edit_skill($this->rid, $id, $this->input->post('title'))){
        $this->system->add_msg(lang('Skill edited'));
      }else{
        $this->system->add_msg(lang('Error in editing skill'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in editing skill') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function remove_skill($id){
    $this->resume->remove_skill($id);
    $this->system->add_msg(lang('Skill removed'));
    redirect('idslot/edit/resume');
  }
  
  public function add_education(){
    $rules = $this->resume->form_rules_event();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      if($this->resume->add_event($this->rid,
                                  null,
                                  $this->input->post('summary'),
                                  $this->input->post('description'),
                                  $this->input->post('start'),
                                  $this->input->post('end'),
                                  'education')){
        $this->system->add_msg(lang('Education added'));
      }else{
        $this->system->add_msg(lang('Error in adding education'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in adding education') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function edit_education($id){
    $rules = $this->resume->form_rules_event();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      $this->resume->edit_event($id,
                                null,
                                $this->input->post('summary'),
                                $this->input->post('description'),
                                $this->input->post('start'),
                                $this->input->post('end'),
                                'education');
      $this->system->add_msg(lang('Education edited'));
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in editing education') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function remove_education($id){
    $this->resume->remove_event($id);
    $this->system->add_msg(lang('Education removed'));
    redirect('idslot/edit/resume');
  }
  
  public function add_experience(){
    $rules = $this->resume->form_rules_event();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      if($this->resume->add_event($this->rid,
                                  $this->input->post('category'),
                                  $this->input->post('summary'),
                                  $this->input->post('description'),
                                  $this->input->post('start'),
                                  $this->input->post('end'),
                                  'experience')){
        $this->system->add_msg(lang('Experience added'));
      }else{
        $this->system->add_msg(lang('Error in adding experience'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in adding experience') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function edit_experience($id){
    $rules = $this->resume->form_rules_event();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      $this->resume->edit_event($id,
                                $this->input->post('category'),
                                $this->input->post('summary'),
                                $this->input->post('description'),
                                $this->input->post('start'),
                                $this->input->post('end'),
                                'experience');
      $this->system->add_msg(lang('Experience edited'));
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in editing experience') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function remove_experience($id){
    $this->resume->remove_event($id);
    $this->system->add_msg(lang('Experience removed'));
    redirect('idslot/edit/resume');
  }
  
  public function add_publication(){
    $rules = $this->resume->form_rules_publication();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      if($this->resume->add_publication($this->rid,
                                        $this->input->post('title'),
                                        $this->input->post('creators'),
                                        $this->input->post('date'),
                                        $this->input->post('urn'),
                                        $this->input->post('urn_type'),
                                        $this->input->post('publisher'))){
        $this->system->add_msg(lang('Publication added'));
      }else{
        $this->system->add_msg(lang('Error in adding publication'));
      }
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in adding publication') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function edit_publication($id){
    $rules = $this->resume->form_rules_publication();
    $this->form_validation->set_rules($rules);
    
    if($this->form_validation->run() == TRUE){
      $this->resume->edit_publication($id,
                                      $this->input->post('title'),
                                      $this->input->post('creators'),
                                      $this->input->post('date'),
                                      $this->input->post('urn'),
                                      $this->input->post('urn_type'),
                                      $this->input->post('publisher'));
      $this->system->add_msg(lang('Publication edited'));
    }else{
      $this->form_validation->set_error_delimiters('&nbsp;&nbsp;','<br />');
      $this->system->add_msg(lang('Error in editing publication') . '<br />' . validation_errors());
    }
    redirect('idslot/edit/resume');
  }

  public function remove_publication($id){
    $this->resume->remove_publication($id);
    $this->system->add_msg(lang('Publication removed'));
    redirect('idslot/edit/resume');
  }
  
  public function build_pdf(){
    $this->resume->build_pdf($this->uid);
    $this->system->render($this->uid);
    redirect('idslot/edit/resume');
  }
  
  public function remove_pdf(){
    $this->resume->remove_pdf($this->uid);
    $this->system->render($this->uid);
    redirect('idslot/edit/resume');
  }
}
