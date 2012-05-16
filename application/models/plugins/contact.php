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
 * Contact model
 **/
class contact extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch contact
   *
   * @param  integer  User id
   * @return array    Contact
   **/
  public function fetch($uid){
    $this->load->database();
    $query = $this->db->query('SELECT * FROM contact WHERE uid = ' . $this->db->escape($uid));

    return $query->row_array();
  }

  /**
   * Add a contact plugin to idslot
   *
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string   Image url
   *              string   Contact
   * @return boolean  True on success and false on failure
   **/
  public function create($uid, $arr){
    $this->load->database();
    $arr['uid'] = $uid;
    $result = $this->db->insert('contact', $arr);
    return $result?$this->db->insert_id():false;
  }

  /**
   * Edit a contact plugin to idslot
   *
   * @param  integer  Contact id
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string   Image url
   *              string   Contact
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->load->database();
    $this->db->where('uid', $uid);
    $result = $this->db->update('contact', $arr);
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
        'field'   => 'contact[title]',
        'label'   => lang('Contact Title'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[description]',
        'label'   => lang('Contact Description'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[email]',
        'label'   => lang('Contact Email'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[tel]',
        'label'   => lang('Contact Telephone'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[fax]',
        'label'   => lang('Contact Fax'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[mob]',
        'label'   => lang('Contact Cellphone'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[website]',
        'label'   => lang('Contact Website'),
        'rules'   => 'xss_clean|prep_url'
      ),
      array(
        'field'   => 'contact[weblog]',
        'label'   => lang('Contact Weblog'),
        'rules'   => 'xss_clean|prep_url'
      ),
      array(
        'field'   => 'contact[map]',
        'label'   => lang('Contact Map'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[address]',
        'label'   => lang('Contact Address'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'contact[postcode]',
        'label'   => lang('Contact Postcode'),
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
    return false;
  }
}
