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
 * Resume model
 **/
class resume extends CI_Model {

  /**
   * Constructor
   **/
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->lang->load('idslot');
      $this->load->helper('language');
  }

  /**
   * Fetch Resume
   *
   * @param  integer  User id
   * @return array    Links
   **/
  public function fetch($uid = ''){
    if(!$uid){
      $uid = $this->session->userdata('user_id');
    }
    
    $query = $this->db->query('SELECT * FROM resume WHERE user_id = ' . $this->db->escape($uid));
    $arr = $query->row_array();
    $rid = $arr['id'];
    $arr['skills'] = $this->fetch_skills($rid);
    $arr['publications'] = $this->fetch_publications($rid);
    $arr['experiences'] = $this->fetch_events($rid, 'experience');
    $arr['educations'] = $this->fetch_events($rid, 'education');
    return $arr;
  }

  /**
   * Add a resume
   *
   * @param  integer  User id
   * @param  array
   * @return boolean  True on success and false on failure
   **/
  public function create($uid, $arr){
    $arr['user_id'] = $uid;
    $result = $this->db->insert('resume', $arr);
    return $result?$this->db->insert_id():false;
  }

  /**
   * Edit a resume plugin to idslot
   *
   * @param  integer  Resume id
   * @param  integer  User id
   * @param  array
   * @return boolean  True on success and false on failure
   **/
  public function update($uid, $arr){
    $this->db->where('user_id', $uid);
    $result = $this->db->update('resume', $arr);
    return $result;
  }

  /**
   * Delete plugin
   **/
  public function delete($uid){
    $resume = $this->fetch($uid);
    
    $this->db->where(array('resume_id'=>$resume['id']));
    $this->db->delete('resume_has_skill');
    
    $this->db->where(array('id'=>$uid));
    $this->db->delete('events');
    
    $this->db->where(array('id'=>$uid));
    $this->db->delete('publications');
    
    $this->db->where(array('user_id'=>$uid));
    return $this->db->delete('resume');
  }

  /**
   * Form rules
   **/
  public function form_rules(){
    return array(
      array(
        'field'   => 'resume[summary]',
        'label'   => lang('Summary'),
        'rules'   => 'xss_clean'
      )
    );
  }

  public function fetch_skills($rid){
    $this->db->from('resume_has_skill');
    $this->db->join('skills', 'skills.id = resume_has_skill.skill_id');
    $this->db->where(array('resume_has_skill.resume_id' => $rid));
    $skills = $this->db->get();
    return $skills->result_array();
  }
  
  public function fetch_skills_like($skill){
    $skill = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $skill);
    $skill = "%{$skill}%";
    $query = $this->db->query('SELECT * FROM skills WHERE title LIKE ' . $this->db->escape($skill));
    return $query->result_array();
  }
  
  public function suggest_skill($skill){
    // if already we have this skill, just return its ID
    // make skill safe for LIKE!
    $temp = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $skill);
    $query = $this->db->query('SELECT * FROM skills WHERE title LIKE ' . $this->db->escape($temp));
    if ($query->num_rows() > 0)
    {
      $row = $query->result();
      return $row[0]->id;
    }
    
    // else insert it
    $data['title'] = $skill;
    if($this->db->insert('skills', $data)){
      return $this->db->insert_id();
    }else{
      return false;
    }
  }

  public function add_skill($rid, $skill){
    $sid = $this->suggest_skill($skill);
    if($this->resume_has_skill($rid, $sid)){
      return false;
    }
    $data = array(
      'resume_id' => $rid,
      'skill_id'=> $sid
    );
    return $this->db->insert('resume_has_skill', $data);
  }
  
  public function edit_skill($rid, $id, $skill){
    $sid = $this->suggest_skill($skill);
    if($this->resume_has_skill($rid, $sid)){
      return false;
    }
    $data['skill_id'] = $sid;
    
    $this->db->where(array('resume_id'=>$rid, 'skill_id'=>$id));
    return $this->db->update('resume_has_skill', $data);
  }
  
  public function remove_skill($id){
    $resume = $this->fetch();
    $this->db->where(array('resume_id'=>$resume['id'], 'skill_id'=>$id));
    return $this->db->delete('resume_has_skill');
  }
  
  public function resume_has_skill($rid, $sid){
    $this->db->where(array('resume_id'=>$rid, 'skill_id'=>$sid));
    $query = $this->db->get('resume_has_skill');
    if($query->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }
  
  public function form_rules_skill(){
    return array(
      array(
        'field'   => 'title',
        'label'   => lang('Title'),
        'rules'   => 'required|xss_clean'
      ),
    );
  }
  
  public function fetch_events($rid, $type){
    $this->db->from('events');
    $this->db->where(array('resume_id' => $rid, 'type' => $type));
    $events = $this->db->get();
    $events = $events->result_array();
    foreach(@$events as $index => $event){
      $events[$index]['start'] = $this->change_date($event['start'], 'to');
      $events[$index]['end'] = $this->change_date($event['end'], 'to');
    }
    return $events;
  }

  public function add_event($rid, $category_id, $summary, $description, $start, $end, $type){
    $start = $this->change_date($start, 'from');
    $end   = $this->change_date($end, 'from');
    $event = array(
      'resume_id'  => $rid,
      'category_id'=> $category_id,
      'summary'    => $summary,
      'description'=> $description,
      'start'      => $start,
      'end'        => $end,
      'type'       => $type
    );
    if(!$this->db->insert('events', $event)){
      return false;
    }
    $eid = $this->db->insert_id();
    return $eid;
  }
  
  public function edit_event($id, $category_id, $summary, $description, $start, $end, $type){
    $start = $this->change_date($start, 'from');
    $end   = $this->change_date($end, 'from');
    $events = array(
      'category_id' => $category_id,
      'summary'     => $summary,
      'description' => $description,
      'start'       => $start,
      'end'         => $end,
      'type'        => $type
    );
    $this->db->where(array('id'=>$id));
    return $this->db->update('events', $events);
  }
  
  public function remove_event($id){
    $uid = $this->session->userdata('user_id');
    $resume = $this->fetch($uid);
    $this->db->where(array('resume_id'=>$resume['id'], 'id'=>$id));
    $this->db->delete('events');
  }
  
  public function form_rules_event(){
    return array(
      array(
        'field'   => 'summary',
        'label'   => lang('Summary'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'description',
        'label'   => lang('Description'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'category',
        'label'   => lang('Category'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'start',
        'label'   => lang('Start'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'end',
        'label'   => lang('End'),
        'rules'   => 'required|xss_clean'
      )
    );
  }
  
  public function fetch_publications($rid){
    $this->db->from('publications');
    $this->db->where(array('resume_id' => $rid));
    $publications = $this->db->get();
    $publications = $publications->result_array();
    foreach(@$publications as $index => $publication){
      $publications[$index]['date'] = $this->change_date($publication['date'], 'to');
    }
    return $publications;
  }

  public function add_publication($rid, $title, $creators, $date, $urn, $urn_type, $publisher){
    $date = $this->change_date($date, 'from');
    $publication = array(
      'title'    => $title,
      'resume_id'=> $rid,
      'creators' => $creators,
      'date'     => $date,
      'urn'      => $urn,
      'urn_type' => $urn_type,
      'publisher'=> $publisher
    );
    if(!$this->db->insert('publications', $publication)){
      return false;
    }
    $pid = $this->db->insert_id();
    return $pid;
  }
  
  public function edit_publication($id, $title, $creators, $date, $urn, $urn_type, $publisher){
    $date = $this->change_date($date, 'from');
    $publication = array(
      'title'    => $title,
      'creators' => $creators,
      'date'     => $date,
      'urn'      => $urn,
      'urn_type' => $urn_type,
      'publisher'=> $publisher
    );
    $this->db->where(array('id'=>$id));
    return $this->db->update('publications', $publication);
  }
  
  public function remove_publication($id){
    $uid = $this->session->userdata('user_id');
    $resume = $this->fetch($uid);
    $this->db->where(array('resume_id'=>$resume['id'], 'id'=>$id));
    $this->db->delete('publications');
  }
  
  public function form_rules_publication(){
    return array(
      array(
        'field'   => 'title',
        'label'   => lang('Title'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'creators',
        'label'   => lang('Creators'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'publisher',
        'label'   => lang('Publisher'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'date',
        'label'   => lang('Date'),
        'rules'   => 'required|xss_clean'
      ),
      array(
        'field'   => 'urn',
        'label'   => lang('URN'),
        'rules'   => 'xss_clean'
      ),
      array(
        'field'   => 'urn_type',
        'label'   => lang('URN type'),
        'rules'   => 'xss_clean'
      )
    );
  }
  
  public function fetch_event_parent_categories(){
    $this->db->from('events_categories');
    $this->db->where(array('pid' => 0));
    $cats = $this->db->get();
    return $cats->result_array();
  }
  
  public function fetch_event_child_categories($id){
    $this->db->from('events_categories');
    $this->db->where(array('pid' => $id));
    $cats = $this->db->get();
    return $cats->result_array();
  }
  
  public function find_parent($id){
    $this->db->from('events_categories');
    $this->db->where(array('id' => $id));
    $cats = $this->db->get();
    $cats = $cats->result_array();
    if(count($cats)){
      return $cats[0]['pid'];
    } else {
      return 0;
    }
  }
  
  public function image_size($action=false){
    return false;
  }
  
  /**
   *@param $date  string  date string
   *@param $type  string  could be "from" or "to". "from" means from a foreign language to gregorian!
   **/
  public function change_date($date, $type = 'from'){
    $this->load->model('tank_auth/users');
    
    $cal = lang('Calendar Type');
    if($cal == 'persian'){
      $this->load->library('persian_calendar');
      if($type == 'from') return $this->persian_calendar->date_p2g($date);
      if($type == 'to')   return $this->persian_calendar->date_g2p($date);
    }
    return $date;
  }
  
  public function build_pdf($uid=false){
    if(!$uid){
      $uid = $this->session->userdata('user_id');
    }
    $this->load->model('plugins/contact');
    $this->load->model('plugins/details');
    
    $user = $this->users->get_user_by_id($uid);
    
    $this->load->model('system');
    $lang = $this->system->languages();
    $this->lang->load('idslot', strtolower($lang[$user->language]));
    
    $data['user']    = $user;
    $data['details'] = $this->details->fetch($uid);
    $data['contact'] = $this->contact->fetch($uid);
    $data['resume']  = $this->fetch($uid);
    
    $resume = $this->load->view('user/plugins/resume_pdf.tpl', $data, true);
    file_put_contents($this->system->render_path('resume') . '/' . $uid . '.html', $resume);
    $cmd = 'xvfb-run wkhtmltopdf -s A4 -B 0 -L 0 -R 0 -T 0 "' . $this->system->render_path('resume') . '/' . $uid . '.html" "' . $this->system->render_path('resume') . '/' . $uid . '.pdf"';
    exec($cmd);
  }
  
  public function remove_pdf($uid=false){
    if(!$uid){
      $uid = $this->session->userdata('user_id');
    }
    @unlink($this->system->render_path('resume') . '/' . $uid . '.html');
    @unlink($this->system->render_path('resume') . '/' . $uid . '.pdf');
  }
}
