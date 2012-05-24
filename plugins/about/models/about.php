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
 * About model
 **/
class About_Model extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch about
   *
   * @param  integer  User id
   * @return array    About
   **/
  public function fetch($uid){
    $this->load->database();
    $this->db->where('uid', $uid);
    $query = $this->db->get('biography');
    
    return $query->row_array();
  }

  /**
   * Add a about plugin to idslot
   *
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string   Image url
   *              string   About
   * @return boolean  True on success and false on failure
   **/
  public function create($uid, $arr){
    $this->load->database();
    $arr['uid'] = $uid;
    $result = $this->db->insert('biography', $arr);
    return $result?$this->db->insert_id():false;
  }

  /**
   * Edit a about plugin to idslot
   *
   * @param  integer  About id
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string   Image url
   *              string   About
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->load->database();
    $this->db->where('uid', $uid);
    $result = $this->db->update('biography', $arr);
    return $result;
  }

  /**
   * Delete plugin
   **/
  public function delete($uid){
    return false;
  }

  /**
   * Form rules
   **/
  public function form_rules(){
    return array(
      array(
        'field'   => 'about[title]',
        'label'   => lang('About Title'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'about[content]',
        'label'   => lang('About Content'),
        'rules'   => 'xss_clean'
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
    return array(
                 'thumb_' => array('100', '100', 0),
                 ''       => array('400', '300', 0)
                );
  }
}
