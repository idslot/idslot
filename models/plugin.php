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
class Plugin extends CI_Model {

  private static $instance;
  protected $models = array();

  public function __construct() {
    self::$instance = & $this;
  }

  public static function &get_instance() {
    return self::$instance;
  }

  public function model($plugin, $model=false) {

    if ($model && $plugin != $model) {
      $model = $plugin . "_" . $model;
    } else {
      $model = $plugin;
    }

    $path = '';
    if (($last_slash = strrpos($model, '/')) !== FALSE) {
      $path = substr($model, 0, ++$last_slash);

      $model = substr($model, $last_slash);
    }

    $name = $model;

    if (in_array($name, $this->models, TRUE)) {
      return;
    }
    $CI = &get_instance();
    if (isset($CI->$name)) {
      show_error('The model name you are loading is the name of a resource that is already being used: ' . $name);
    }
    
    $plugin = strtolower($plugin);
    $model = strtolower($model);

    require_once(APPPATH . 'plugins/' . $plugin . '/models/' . $path . $model . '.php');

    $model = ucfirst($name) . '_Model';
    $CI->$name = new $model();
    $this->models[] = $name;
    return;
  }

  public function view($plugin, $view, $vars = array(), $return = FALSE) {
    $CI = &get_instance();
    return $CI->load->view('../plugins/' . $plugin . '/views/' . $view, $vars, $return);
  }

}