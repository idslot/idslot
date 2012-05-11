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
  function __construct(){
    parent::__construct();
    $this->load->library('session');
  }
  
  /**
   * Render idslot
   *
   * @param  integer  user id
   * @return mixed    idslot
   **/
  function render($uid){
    $this->load->helper('path');
    $this->load->helper('file');
    $this->load->library('html_purifier');
    $this->load->model('tank_auth/users');
    
    $data['user'] = $this->users->get_user_by_id($uid);
    $username = $data['user']->username;
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    umask(0);
    
    @mkdir("{$ids_path}/application/views/idslot/files/", $this->config->item('dir_perm'), true);
    $plugins = $this->config->item('plugins');

    $this->load->model('plugins/photos');
    $data['photoss'] = $this->photos->fetch($uid);
    
    $this->load->model('plugins/links');
    $data['linkss'] = $this->links->fetch($uid);
    
    $data = $this->html_purifier->purify($data);
    
    foreach($plugins as $pname=>$ptitle){
      $this->load->model("plugins/{$ptitle}");
      $subdata = $this->html_purifier->purify($this->$ptitle->fetch($uid));
      $data['plugins'][$pname] = $this->load->view('templates/' . $data['user']->template . '/plugins/' . $pname . '.tpl', $subdata, true);
    }
    
    if(is_file("{$ids_path}/application/views/idslot/files/resume/{$uid}.pdf")){
      $data['has_resume'] = true;
    } else {
      $data['has_resume'] = false;
    }
    
    $idslot = $this->load->view('templates/' . $data['user']->template . '/index.tpl', $data, true);
    write_file("{$ids_path}/application/views/idslot/index.html", $idslot);
    
    // write contact file
    write_file("{$ids_path}/application/views/idslot/contact.php",
'<?php
error_reporting(0);
session_start();
if($_SESSION[\'captcha_\' . md5(\'' . $uid . '\')] == $_POST[\'captcha\']){
require_once(\'../../contact.php\');
send_email(' . $uid . ',$_POST[\'name\'],$_POST[\'email\'],$_POST[\'message\']);
}
header("Location: {$_SERVER[\'HTTP_REFERER\']}");
');
    
    // create symlink to template
    @unlink("{$ids_path}/application/views/idslot/theme");
    symlink("{$ids_path}/application/views/themes/{$data['user']->template}/", "application/views/idslot/theme");
  }
  
  function upload_images($uid, $sizes=false, $id=false)
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
    $ids_path = "{$ids_path}/application/views/idslot/";
    umask(0);
    $plugins['details'] = 'Details';
    $plugins['settings'] = 'Settings';
    
    foreach($plugins as $plugin => $ptitle){
      @mkdir($ids_path . "files/{$plugin}", $this->config->item('dir_perm'), true);
      
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

  function add_msg($msg){
    $this->load->library('session');
    $msgs = $this->session->userdata('msgs');
    $msgs[] = $msg;
    $data['msgs'] = $msgs;
    $this->session->set_userdata($data);
  }

  function get_msgs(){
    $this->load->library('session');
    $msgs = $this->session->userdata('msgs');
    $this->session->unset_userdata('msgs');
    return $msgs;
  }
  
  function choose_language(){
    $languages = $this->config->item('languages');
    $lang = $this->change_language('');
    
    $this->config->set_item('language', strtolower($languages[$lang]));
  }
  
  function change_language($lang){
    $languages = $this->config->item('languages');
    if(!array_key_exists($lang, $languages)){
      $lang = key($languages);
    }
    $cookie = array('name'=>'lang', 'value'=>$lang, 'expire'=>'86400');
    $this->input->set_cookie($cookie);
    return $lang;
  }
  
  function rrmdir($dir) {
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
  
  function render_path($plugin=''){
    $uid = $this->session->userdata('user_id');
    $username = $this->session->userdata('username');
    $ids_path = dirname($_SERVER['SCRIPT_FILENAME']);
    umask(0);
    
    @mkdir("{$ids_path}/application/views/idslot/files/" . $plugin, $this->config->item('dir_perm'), true);
    return "{$ids_path}/application/views/idslot/files/" . $plugin;
  }
  
  function is_required($data, $field, $css_class = 'required'){
    if(!isset($data[$field])){
      return '';
    }
    $data[$field] = explode('|', $data[$field]['rules']);
    return in_array('required', $data[$field]) ? $css_class : '';
  }
}
