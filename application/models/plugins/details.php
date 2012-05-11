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
 * Details model
 **/
class details extends CI_Model {

  /**
   * Constructor
   **/
  function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch user details
   *
   * @param  integer  User id
   * @return array    user
   **/
  function fetch($uid){
    $this->load->database();
    $query = $this->db->query('SELECT * FROM user WHERE id = ' . $this->db->escape($uid));

    return $query->row_array();
  }

  /**
   * Edit detail of user to idslot
   *
   * @param  integer  User id
   * @param  array
   * @return boolean  True on success and false on failure
   **/
  function update($uid, $arr){
    $this->load->library('tank_auth');
    $this->lang->load('tank_auth');
    
    $email_pass = $arr['email_password'];
    unset($arr['email_password']);
    
    // add message queue actions for add email / del email / change email / change password
    $this->load->library('msg_queue');
    $user = $this->fetch($uid);
    $args['domain'] = $user['domain'];
    $args['local_email'] = $arr['local_email'];
    
    if($user['domain'] != ''){
      if($user['local_email'] == ''){ // if email is new
        if($arr['local_email'] != '' && $email_pass != ''){
          $args['password'] = $email_pass;
          $args['title'] = $user['title'];
          $this->msg_queue->add_msg('idslot', 'idslot::add_email', $args);
        }elseif($arr['local_email'] != '' && $email_pass == ''){
          $args['local_email'] = $arr['local_email'] = '';
          $this->system->add_msg(lang('Please fill password for local email'));
        }
      } elseif($arr['local_email'] == '') { // delete email
        $args['local_email'] = $user['local_email'];
        $this->msg_queue->add_msg('idslot', 'idslot::remove_email', $args);
      } elseif($arr['local_email'] == $user['local_email']) { // then, if he didn't change email
        if($email_pass != ''){ // change password too
          $args['password'] = $email_pass;
          $this->msg_queue->add_msg('idslot', 'idslot::change_email_password', $args);
        }
      } else { // edit email
          $args['old_local_email'] = $user['local_email'];
          $this->msg_queue->add_msg('idslot', 'idslot::change_email', $args);
        if($email_pass != ''){ // change password too
          $args['password'] = $email_pass;
          $this->msg_queue->add_msg('idslot', 'idslot::change_email_password', $args);
        }
      }

      // check for title
      // if the user already has email AND title changed!
      if($user['local_email'] != '' && $user['title'] != $arr['title']) {
        $args['title'] = $arr['title'];
        $this->msg_queue->add_msg('idslot', 'idslot::change_email_title', $args);
      }
    }else{
      $arr['local_email'] = '';
    }
    //////////
    $user = $this->users->get_user_by_id($uid);
    
    $result = $this->tank_auth->update_user($uid, $user->username,
                                            false,
                                            false,
                                            $arr['title'],
                                            $arr['short_description'],
                                            $user->domain,
                                            $arr['template'],
                                            $arr['language'],
                                            $arr['meta_keywords'],
                                            $arr['meta_description'],
                                            1, 0, 
                                            $arr['local_email']);
    if(is_null($result)){
      $errors = $this->tank_auth->get_error_message();
      foreach ($errors as $k => $v){
        $this->system->add_msg(lang($v));
      }
      return false;
    }else{
      // check if language changed
      if($arr['language'] != $user->language){
        $this->load->model('plugins/resume');
        $this->resume->build_pdf($uid);
      }
      return true;
    }
  }

  /**
   * Form rules
   **/
  function form_rules(){
    return array(
      array(
        'field'   => 'details[title]',
        'label'   => lang('Title'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'details[short_description]',
        'label'   => lang('Short Description'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'details[meta_keywords]',
        'label'   => lang('Meta Keywords'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'details[meta_description]',
        'label'   => lang('Meta Description'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'details[local_email]',
        'label'   => lang('Local Email'),
        'rules'   => 'alpha_dash|xss_clean'
      ),
      array(
        'field'   => 'details[email_password]',
        'label'   => lang('Email Password'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'details[template]',
        'label'   => lang('Template'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'details[language]',
        'label'   => lang('Language'),
        'rules'   => 'required|xss_clean'
      ),
    );
  }
  
    
  /**
   * Return image size
   *
   * @param string  action
   * @return  array image sizes
   **/
  function image_size($action=false){
    return false;
  }
}
