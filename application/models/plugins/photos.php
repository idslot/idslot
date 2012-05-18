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
 * Photos model
 **/
class photos extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
    $this->lang->load('idslot');
    parent::__construct();
  }

  /**
   * Fetch photos
   *
   * @param  integer  User id
   * @return array    Photos
   **/
  public function fetch($uid){
    $this->load->database();
    $query = $this->db->query('SELECT * FROM portfolio WHERE uid = ' . $this->db->escape($uid));
    $arr = $query->row_array();
    $query = $this->db->query('SELECT * FROM portfolio_list WHERE pid=' . $this->db->escape($arr['id']) . ' ORDER BY sort, id DESC');
    $arr['photoss'] = $query->result_array();

    return $arr;
  }

  /**
   * Add a photos plugin to idslot
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
    $result = $this->db->insert('portfolio', $arr);
    return $result?$this->db->insert_id():false;
  }

  /**
   * Edit a photos plugin to idslot
   *
   * @param  integer  Photos id
   * @param  integer  User id
   * @param  array:
   *              string  Title of page
   *              string  Description
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->load->database();
    $this->db->where('uid', $uid);
    $result = $this->db->update('portfolio', $arr);
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
                         'field'   => 'photos[title]',
                         'label'   => lang('Photos Title'),
                         'rules'   => 'xss_clean'
                      ),
                   array(
                         'field'   => 'photos[description]',
                         'label'   => lang('Photos Content'),
                         'rules'   => 'xss_clean'
                      )
                );
  }
  
  public function row_form_rules(){
    return array(
                   array(
                         'field'   => 'content',
                         'label'   => lang('Content'),
                         'rules'   => 'required|xss_clean'
                      ),
                   array(
                         'field'   => 'photos_file',
                         'label'   => lang('Image'),
                         'rules'   => 'xss_clean'
                      )
                );    
  }

  public function fetch_row($id){
    $this->load->database();
    $uid = $this->session->userdata('user_id');
    $query = $this->db->query('SELECT pl.* FROM portfolio_list pl, portfolio p
                              WHERE pl.id = ' . $this->db->escape($id) . '
                              AND pl.pid = p.id AND p.uid = ' . $this->db->escape($uid));
    return $query->row_array();
  }

  public function add_row($pid, $content){
    $this->load->database();
    $uid = $this->session->userdata('user_id');
    $this->db->where('uid', $uid);
    $query = $this->db->get('portfolio');
    $result = $query->row_array();
    if($result['id'] == $pid){
      $data['pid'] = $pid;
      $data['content'] = $content;
      return $this->db->insert('portfolio_list', $data)?$this->db->insert_id():false;
    }
    return false;
  }

  public function edit_row($id, $content){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $query = $this->db->query('SELECT * FROM portfolio WHERE uid = ' . $this->db->escape($uid));
    $p = $query->row_array();
    
    $data['content'] = $content;
    $this->db->where(array('id' => $id, 'pid' => $p['id']));
    return $this->db->update('portfolio_list', $data);
  }

  public function remove_row($id){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $query = $this->db->query('SELECT * FROM portfolio WHERE uid = ' . $this->db->escape($uid));
    $p = $query->row_array();
    
    $this->db->where(array('id' => $id, 'pid' => $p['id']));
    return $this->db->delete('portfolio_list');
  }

  public function sort($serial){
    $this->load->database();
    
    $uid = $this->session->userdata('user_id');
    
    $query = $this->db->query('SELECT * FROM portfolio WHERE uid = ' . $this->db->escape($uid));
    $p = $query->row_array();
    
    $count = count($serial);
    for($i=0; $i<$count; $i++){
      $data['sort'] = $i+1;
      $this->db->where(array('id' => $serial[$i], 'pid' => $p['id']));
      $this->db->update('portfolio_list', $data);
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
    return array(
                 'thumb_' => array('80', '80', 1),
                 ''       => array('640', '480', 0)
                );
  }
}
