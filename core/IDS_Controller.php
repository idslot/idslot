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

class IDS_Controller extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('security');
    $this->load->library('tank_auth');
    $this->load->model('system');
    $this->system->choose_language();
    $this->load->model('plugin');
    $this->lang->load('tank_auth');
    $this->lang->load('idslot');
    $this->load->helper('language');
    if (!$this->tank_auth->is_logged_in()) {
      redirect('auth/login');
    }
  }
}
