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
 * Idslot Model
 **/
class System extends CI_Model {
  
  /**
   * Constructor
   **/
  public function __construct(){
    parent::__construct();
    $this->load->library('session');
  }
  
  /**
   * Render idslot
   *
   * @param  integer  user id
   * @return mixed    idslot
   **/
  public function render($uid){
    $this->load->helper('path');
    $this->load->helper('file');
    $this->load->library('html_purifier');
    $this->load->model('tank_auth/users');
    
    $data['uid'] = $uid;
    $data['user'] = $this->users->get_user_by_id($uid);
    $username = $data['user']->username;
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    umask(0);
    
    @mkdir("{$ids_path}/views/idslot/files/", $this->config->item('dir_perm'), true);
    @file_put_contents("{$ids_path}/views/idslot/files/index.html", "");
    $plugins = $this->config->item('plugins');

    $this->load->model('plugins/photos');
    $data['photoss'] = $this->photos->fetch($uid);
    
    $this->load->model('plugins/links');
    $data['linkss'] = $this->links->fetch($uid);
    
    $data = $this->html_purifier->purify($data);
    $data['plugins'] = array();
    foreach($plugins as $pname=>$ptitle){
      $this->load->model("plugins/{$ptitle}");
      $subdata = $this->html_purifier->purify($plugin_data = $this->$ptitle->fetch($uid));
      if($plugin_data['visible'] == 1){
        $data['plugins'][$pname]['title'] = $plugin_data['title'];
        $data['plugins'][$pname]['view'] = $this->load->view('templates/' . $data['user']->template . '/plugins/' . $pname, $subdata, true);
      }
    }
    
    if(is_file("{$ids_path}/views/idslot/files/resume/{$uid}.pdf")
    || is_file("{$ids_path}/views/idslot/files/resume/{$uid}.html")){
      $data['has_resume'] = true;
    } else {
      $data['has_resume'] = false;
    }
    
    $idslot = $this->load->view('templates/' . $data['user']->template . '/index', $data, true);
    write_file("{$ids_path}/views/idslot/index.html", $idslot);
    
    // create symlink to template
    @unlink("{$ids_path}/views/idslot/theme");
    symlink("{$ids_path}/views/templates/{$data['user']->template}/theme/", "views/idslot/theme");
  }
  
  public function upload_images($uid, $sizes=false, $id=false)
  {
    $plugins = $this->config->item('plugins');
    $this->load->model('tank_auth/users');
    $this->load->helper('file');
    $this->load->helper('path');
    
    if(!$sizes){
      $sizes = array(
                     '' => array('100', '100', 0)
                     );
    }
    
    $data['user'] = $this->users->get_user_by_id($uid);
    $username = $data['user']->username;
    
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    $ids_path = "{$ids_path}/views/idslot/";
    umask(0);
    $plugins['details'] = 'Details';
    $plugins['settings'] = 'Settings';
    
    foreach($plugins as $plugin => $ptitle){
      @mkdir($ids_path . "files/{$plugin}", $this->config->item('dir_perm'), true);
      @file_put_contents($ids_path . "files/{$plugin}/index.html", "");
      
      $config['upload_path'] = $ids_path . "files/{$plugin}";
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      
      // Upload file
      $this->load->library('upload', $config);
      if($this->upload->do_upload($plugin . '_file')){
        $upload_data = $this->upload->data();
        if($id){
          $new_image = $uid . '-' . $id . '.png';
        }else{
          $new_image = $uid . '.png';
        }
        $this->load->library('image_lib');
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image']  = $upload_data['full_path'];
        foreach($sizes as $prefix=>$size){
          $config['new_image']     = $ids_path . "files/{$plugin}/{$prefix}{$new_image}";
          if($size[2]){
            $crop_config = $config;
            $crop_config['maintain_ratio'] = false;
            $img_size = getimagesize($crop_config['source_image']);
            $xratio = $img_size[0] / $size[0];
            $yratio = $img_size[1] / $size[1];
            if($xratio > $yratio){
              $crop_config['x_axis'] = $img_size[0] - $size[0] * $yratio;
              $crop_config['y_axis'] = 0;  
              $crop_config['width']  = $size[0] * $yratio;
              $crop_config['height'] = $img_size[1];
            }else{
              $crop_config['x_axis'] = 0;
              $crop_config['y_axis'] = $img_size[1] - $size[1] * $xratio;  
              $crop_config['width']  = $img_size[0];
              $crop_config['height'] = $size[1] * $xratio;
            }
            $this->image_lib->initialize($crop_config); 
            $this->image_lib->crop();
            $config['source_image'] = $config['new_image'];
          }else{
            $config['source_image']  = $upload_data['full_path'];
          }
          $config['maintain_ratio'] = true;
          $config['master_dim'] = 'auto';
          $config['width']         = $size[0];
          $config['height']        = $size[1];
          $this->image_lib->initialize($config); 
          $this->image_lib->resize();
        }
        
        // remove the big image!
        unset($this->upload);
        unlink($upload_data['full_path']);
      }
    }
  }

  public function add_msg($msg){
    $this->load->library('session');
    $msgs = $this->session->userdata('msgs');
    $msgs[] = $msg;
    $data['msgs'] = $msgs;
    $this->session->set_userdata($data);
  }

  public function get_msgs(){
    $this->load->library('session');
    $msgs = $this->session->userdata('msgs');
    $this->session->unset_userdata('msgs');
    return $msgs;
  }
  
  public function choose_language(){
    $this->load->library('tank_auth');
    $uid = $this->session->userdata('user_id');
    $lang = $this->users->get_user_by_id($uid);
    $languages = $this->system->languages();
    
    if($lang){
      $lang = $lang->language;
    }elseif($this->input->cookie('lang')){
      $lang = $this->input->cookie('lang');
    }else{
      $lang = '';
    }
    return $this->change_language($lang);
  }
  
  public function change_language($lang){
    $languages = $this->system->languages();
    if(!array_key_exists($lang, $languages)){
      $lang = 'en';
    }

    _setlocale(LC_MESSAGES, $lang);
    $domain = 'idslot';
    _bindtextdomain($domain, FCPATH . APPPATH . 'language/locale');
    _bind_textdomain_codeset($domain, "UTF-8");
    _textdomain($domain);
    
    $cookie = array('name'=>'lang', 'value'=>$lang, 'expire'=>'86400');
    $this->input->set_cookie($cookie);
    return $lang;
  }
  
  public function rrmdir($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != '.' && $object != '..') {
          if (filetype($dir.'/'.$object) == 'dir') self::rrmdir($dir.'/'.$object); else unlink($dir.'/'.$object);
        }
      }
      reset($objects);
      rmdir($dir);
    }
  }
  
  public function render_path($plugin=''){
    $uid = $this->session->userdata('user_id');
    $username = $this->session->userdata('username');
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    umask(0);
    
    @mkdir("{$ids_path}/views/idslot/files/" . $plugin, $this->config->item('dir_perm'), true);
    return "{$ids_path}/views/idslot/files/" . $plugin;
  }
  
  public function view(){
    return $this->load->view('idslot/index.html');
  }
  
  public function is_required($data, $field, $css_class = 'required'){
    if(!isset($data[$field])){
      return '';
    }
    $data[$field] = explode('|', $data[$field]['rules']);
    return in_array('required', $data[$field]) ? $css_class : '';
  }
  
  public function templates(){
    $templates = array();
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    $dirs = scandir($ids_path . '/views/templates');
    
    foreach($dirs as $dir){
      if(is_dir($ids_path . '/views/templates/' . $dir) && strpos($dir, '.') !== 0 && file_exists($ids_path . '/views/templates/' . $dir . '/index.php')){
        $templates[$dir] = $dir;
      }
    }
    
    return $templates;
  }
  
  public function languages(){
    $languages = array();
    $locales = $this->config->item('locales');
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    $dirs = scandir($ids_path . '/language/locale');
    
    foreach($dirs as $dir){
      if(is_dir($ids_path . '/language/locale/' . $dir) && strpos($dir, '.') !== 0 && file_exists($ids_path . '/language/locale/' . $dir . '/LC_MESSAGES/idslot.mo') && array_key_exists($dir, $locales)){
        $languages[$dir] = $locales[$dir];
      }
    }
    
    return $languages;
  }
}
