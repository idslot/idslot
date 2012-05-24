<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

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
class Plugins extends CI_Controller {

  public function __construct() {
    $RTR = & load_class('Router', 'core');
    $URI = & load_class('URI', 'core');
    $segments = $URI->rsegments;
    if (count($segments) < 2) {
      show_error('Unable to load your controller.');
    } elseif (count($segments) > 2 && file_exists(APPPATH . 'plugins/' . $segments[2] . '/controllers/' . $segments[3] . '.php')){
      $plugin = $segments[2];
      $controller = $plugin . '_' . $segments[3];
      if (isset($segments[4])) {
        $method = $segments[4];
      } else {
        $method = 'index';
      }
      $request = array_slice($segments, 4);
    }else{
      $plugin = $segments[2];
      $controller = $plugin;
      if (isset($segments[3])) {
        $method = $segments[3];
      } else {
        $method = 'index';
      }
      $request = array_slice($segments, 3);
    }
    $plugin = strtolower($plugin);
    $controller = strtolower($controller);
      
    if (!file_exists(APPPATH . 'plugins/' . $plugin . '/controllers/' . $controller . '.php')) {
      show_error('Unable to load your controller.');
    }
    
    include(APPPATH . 'plugins/' . $plugin . '/controllers/' . $controller . '.php');
    $controller = ucfirst($controller) . '_Controller';
    $IDS = new $controller();

    if (!in_array(strtolower($method), array_map('strtolower', get_class_methods($IDS)))) {

      if (!empty($RTR->routes['404_override'])) {
        $x = explode('/', $RTR->routes['404_override'], 2);
        $class = $x[0];
        $method = isset($x[1]) ? $x[1] : 'index';
        if (!class_exists($class)) {
          if (!file_exists(APPPATH . 'controllers/' . $class . '.php')) {
            show_404($class . '/' . $method);
          }

          include_once(APPPATH . 'controllers/' . $class . '.php');
          unset($IDS);
          $IDS = new $class();
        }
      } else {
        show_404($class . '/' . $method);
      }
    }

    // Call the requested method.
    // Any URI segments present (besides the class/function) will be passed to the method for convenience
    call_user_func_array(array(&$IDS, $method), $request);
    self::$instance = &$IDS;
    
    foreach (is_loaded() as $var => $lclass) {
      $this->$var = & load_class($lclass);
    }

    $this->load = & load_class('Loader', 'core');
    $this->load->initialize();
  }

}

