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
class IDS_Form_validation extends CI_Form_validation {

  public $_field_data = array();

  public function __construct($rules = array()) {
    return parent::__construct($rules);
  }

  public function specialchars($data = '') {
    if (is_array($data)) {
      foreach ($data as $key => $val) {
        $data[$key] = $this->specialchars($val);
      }

      return $data;
    }

    return str_replace(array("'", '"', '<', '>'), array('&#39;', '&quot;', '&lt;', '&gt;'), stripslashes($data));
  }

}