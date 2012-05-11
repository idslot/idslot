<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
require_once('htmlpurifier/HTMLPurifier.auto.php');

class html_purifier
{
  private $hp;
  private $excludes = array('map', 'links');
  
  function __construct()
  {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
    $config->set('HTML.TidyLevel', 'heavy');
    $config->set('AutoFormat.Linkify', true);
    $config->set('Core.EscapeInvalidTags', true);
    $config->set('Cache.DefinitionImpl', null);
    
    $this->hp = new HTMLPurifier($config);
  }
  
  function purify($param)
  {
    if(is_array($param)){
      return $this->array_purifier($param);
    } elseif(is_object($param)){
      return $this->object_purifier($param);
    } else {
      return $this->hp->purify($param);
    }
  }
  
  function array_purifier($array)
  {
    $key = $val = '';
    foreach($array as $key => $val){
      if(in_array($key, $this->excludes, true)) continue;
      $array[$key] = $this->purify($val);
    }
    
    return $array;
  }
  
  function object_purifier($object)
  {
    $vars = get_object_vars($object);
    
    foreach($vars as $key => $val){
      if(in_array($key, $this->excludes)) continue;
      $object->$key = $this->purify($val);
    }
    
    return $object;
  }
}
