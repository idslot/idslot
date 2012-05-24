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
 * Links model
 **/
class Links_Model extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch links
   *
   * @param  integer  User id
   * @return array    Links
   **/
  public function fetch($uid){
    $this->load->database();
    $this->db->where('uid', $uid);
    $query = $this->db->get('social');

    $arr = $query->row_array();
    $this->db->where('sid', $arr['id']);
    $this->db->order_by('sort');
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('social_links');
    $arr['links'] = $query->result_array();
    return $arr;
  }

  /**
   * Add a links plugin to idslot
   *
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string  Description
   * @return boolean  True on success and false on failure
   **/
  public function create($uid, $arr){
    $this->load->database();
    $arr['uid'] = $uid;
    $result = $this->db->insert('social', $arr);
    return $result?$this->db->insert_id():false;
  }

  /**
   * Edit a links plugin to idslot
   *
   * @param  integer  Links id
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string  Description
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->load->database();
    $this->db->where('uid', $uid);
    $result = $this->db->update('social', $arr);
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
                         'field'   => 'links[title]',
                         'label'   => lang('Links Title'),
                         'rules'   => 'xss_clean|prep_for_form'
                      ),
                   array(
                         'field'   => 'links[description]',
                         'label'   => lang('Links Description'),
                         'rules'   => 'xss_clean|prep_for_form'
                      )
                );
  }
  
  public function row_form_rules(){
    return array(
      array(
        'field'   => 'name', 
        'label'   => lang('Title'), 
        'rules'   => 'required|xss_clean|prep_for_form'
      ),
      array(
        'field'   => 'url', 
        'label'   => lang('Url'), 
        'rules'   => 'required|xss_clean|prep_url|prep_for_form'
      ),
      array(
        'field'   => 'icon', 
        'label'   => 'Icon', 
        'rules'   => 'xss_clean|prep_for_form'
      )
    );
  }

  public function fetch_row($id){
    $this->load->database();
    $uid = $this->session->userdata('user_id');
    $this->db->select('social_links.*');
    $this->db->from('social_links');
    $this->db->join('social', 'social.id = social_links.sid');
    $this->db->where('social_links.id', $id);
    $this->db->where('uid', $uid);
    $query = $this->db->get();

    return $query->row_array();
  }

  public function add_row($sid, $name, $url, $icon){
    $this->load->database();
    $uid = $this->session->userdata('user_id');
    $this->db->where('uid', $uid);
    $query = $this->db->get('social');
    $result = $query->row_array();
    if($result['id'] == $sid){
      $data = array('sid' =>$sid,
                    'name'=>$name,
                    'url' =>$url,
                    'icon'=>$icon
              );
      return $this->db->insert('social_links', $data);
    }
    return false;
  }

  public function edit_row($id, $name, $url, $icon){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $this->db->where('uid', $uid);
    $query = $this->db->get('social');
    $s = $query->row_array();
    
    $data = array('name'=>$name,
                  'url' =>$url,
                  'icon'=>$icon
            );
    $this->db->where(array('id' => $id, 'sid' => $s['id']));
    return $this->db->update('social_links', $data);
  }

  public function remove_row($id){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $this->db->where('uid', $uid);
    $query = $this->db->get('social');
    $s = $query->row_array();
    
    $this->db->where(array('id' => $id, 'sid' => $s['id']));
    return $this->db->delete('social_links');
  }
  
  public function sort($serial){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $this->db->where('uid', $uid);
    $query = $this->db->get('social');
    $s = $query->row_array();
    
    $count = count($serial);
    for($i=0; $i<$count; $i++){
      $data['sort'] = $i+1;
      $this->db->where(array('id' => $serial[$i], 'sid' => $s['id']));
      $this->db->update('social_links', $data);
    }
    return true;
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
