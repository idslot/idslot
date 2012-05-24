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
class Details_Model extends CI_Model {

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
    $this->load->library('tank_auth');
    $this->lang->load('tank_auth');
    
    //////////
    $user = $this->users->get_user_by_id($uid);
    
    $result = $this->tank_auth->update_user($uid, $user->username,
                                            false,
                                            false,
                                            $arr['title'],
                                            $arr['short_description'],
                                            $arr['template'],
                                            $arr['language'],
                                            $arr['meta_keywords'],
                                            $arr['meta_description']);
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
  public function form_rules(){
    return array(
      array(
        'field'   => 'details[title]',
        'label'   => lang('Title'),
        'rules'   => 'required|xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'details[short_description]',
        'label'   => lang('Short Description'),
        'rules'   => 'xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'details[meta_keywords]',
        'label'   => lang('Meta Keywords'),
        'rules'   => 'xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'details[meta_description]',
        'label'   => lang('Meta Description'),
        'rules'   => 'xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'details[template]',
        'label'   => lang('Template'),
        'rules'   => 'required|xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'details[language]',
        'label'   => lang('Language'),
        'rules'   => 'required|xss_clean|prep_for_form'
      ),
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
}
