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
class Update extends IDS_Controller {

  public function index() {
    $data['config'] = is_writable(APPPATH . "config/config.php");
    $data['etc_dir'] = is_writable(APPPATH . "etc/tmp/");
    $data['current_version'] = $this->config->item('version');
    $data['local_version'] = $this->system->check_local_update();
    $data['remote_version'] = $this->system->check_remote_update();
    $data['auto_update'] = false;

    if ($data['config'] && $data['etc_dir'] && !$data['local_version'] && $data['remote_version']) {
      $files = array();
      $file_name = 'FILES_' . $data['current_version'] . '-' . $data['remote_version'];
      if (!file_exists(APPPATH . 'etc/tmp/' . $file_name)) {
        @copy("http://repository.idslot.org/stable/" . $file_name . '.txt', APPPATH . 'etc/tmp/' . $file_name);
      }
      $files = @file(APPPATH . 'etc/tmp/' . $file_name);
      if (is_array($files) && count($files) > 0) {
        $data['auto_update'] = true;
        foreach ($files as $file) {
          $file = explode('|', trim($file));
          switch ($file[0]) {
            case '#':
            case '-':
              $check = is_writable(FCPATH . APPPATH . $file[1]);
              break;
            case '+':
              $check = is_writable(dirname(APPPATH . $file[1]));
              if ($check && file_exists(APPPATH . $file[1]) && !is_writable(APPPATH . $file[1])) {
                $check = false;
              }
              break;
            default:
              $check = false;
          }

          if (!$check) {
            $data['auto_update'] = false;
            break;
          }
        }
      }
    }
    $this->load->view('user/update', $data);
  }

  public function local() {
    $current_version = $this->config->item('version');
    $versions = file(APPPATH . 'etc/VERSIONS');
    if (trim($versions[0]) == $current_version) {
      $this->system->add_msg(__("There are no update for IDSlot.") . $current_version);
      redirect('idslot');
      return;
    }
    $steps = count($versions) - 1;
    for ($i = $steps; $i >= 0; $i--) {
      $versions[$i] = trim($versions[$i]);
      if ($this->compare($versions[$i], $current_version)) {
        $current_version = $this->update_version($current_version, $versions[$i]);
      }
    }
    $this->system->add_msg(__("IDSlot updated to ") . $current_version);
    redirect('idslot');
  }

  public function remote() {
    $current_version = $this->config->item('version');
    $remote_version = $this->system->check_remote_update();
    if ($remote_version == $current_version) {
      $this->system->add_msg(__("There are no update for IDSlot.") . $current_version);
      redirect('idslot');
      return;
    }
    $file_name = 'idslot_' . $current_version . '-' . $remote_version;
    copy("http://repository.idslot.org/stable/download/" . $file_name . '.zip', APPPATH . 'etc/tmp/' . $file_name . '.zip');

    if (ini_get('mbstring.func_overload') && function_exists('mb_internal_encoding')) {
      $previous_encoding = mb_internal_encoding();
      mb_internal_encoding('ISO-8859-1');
    }
    $this->load->helper('pclzip');
    $archive = new PclZip(FCPATH . APPPATH . 'etc/tmp/' . $file_name . '.zip');
    mkdir(FCPATH . APPPATH . 'etc/tmp/' . $file_name);
    $files = $archive->extract(PCLZIP_OPT_PATH, FCPATH . APPPATH . 'etc/tmp/' . $file_name);
    if (isset($previous_encoding)) {
      mb_internal_encoding($previous_encoding);
    }

    if (!is_array($files) || count($files) == 0) {
      $this->system->add_msg(__("Error in archive file!"));
      redirect('update');
      return;
    }
    unset($archive);
    unset($files);

    $files = file(APPPATH . 'etc/tmp/FILES_' . $current_version . '-' . $remote_version);
    foreach ($files as $file) {
      $file = explode('|', trim($file));
      switch ($file[0]) {
        case '#':
        case '+':
          if (strrpos($file[1], '/') == strlen($file[1]) - 1) {
            mkdir(FCPATH . APPPATH . $file[1]);
          } else {
            $content = file_get_contents(FCPATH . APPPATH . 'etc/tmp/' . $file_name . '/' . $file[1]);
            file_put_contents(FCPATH . APPPATH . $file[1], $content);
            unset($content);
          }
          break;
        case '-':
          if (strrpos($file[1], '/') == strlen($file[1]) - 1) {
            $this->system->rmdir(FCPATH . APPPATH . $file[1]);
          } else {
            unlink(FCPATH . APPPATH . $file[1]);
          }
      }
    }
    unset($files);
    unlink(APPPATH . 'etc/tmp/FILES_' . $current_version . '-' . $remote_version);
    unlink(APPPATH . 'etc/tmp/' . $file_name . '.zip');
    $this->system->rmdir(APPPATH . 'etc/tmp/' . $file_name);
    
    $current_version = $this->update_version($current_version, $remote_version);
    $this->system->add_msg(__("IDSlot updated to ") . $current_version);
    redirect('idslot');
  }

  private function update_version($from, $to) {
    if ($this->config->item('version') != $from) {
      return;
    }
    $this->import_sql("etc/idslot_mysql_$from-$to.sql");
    $this->set_var('config/config.php', "\$config['version']", $to);
    return $to;
  }

  private function compare($new, $old) {
    return version_compare($new, $old, '>');
  }

  private function set_var($file, $var, $val) {
    $content = file_get_contents(APPPATH . $file);
    $cvar = str_replace(array('$', '[', ']'), array('\$', '\[', '\]'), $var);
    if (is_array($var)) {
      $count = count($var);
      if ($count != count($val)) {
        return false;
      }
      for ($i = 0; $i < $count; $i++) {
        $val[$i] = '$1\'' . $val[$i] . '\';';
        $var[$i] = '/(\s*' . $cvar[$i] . '\s*=\s*)[^;]+;/i';
      }
    } else {
      $val = '$1\'' . $val . '\';';
      $var = '/(\s*' . $cvar . '\s*=\s*)[^;]+;/i';
    }
    $content = preg_replace($var, $val, $content);
    file_put_contents(APPPATH . $file, $content);
    return true;
  }

  private function import_sql($file) {
    if (!file_exists(APPPATH . $file)) {
      return;
    }
    $this->load->database();
    $query = '';
    $lines = file(APPPATH . $file);
    foreach ($lines as $line) {
      $line = str_replace('#_', $this->db->dbprefix, $line);
      $line = trim($line);
      if (strpos($line, '-') !== 0 && strlen($line)) {
        $query .= $line;
      }

      if (strrpos($line, ';') === strlen($line) - 1) {
        $this->db->query($query);
        $query = '';
      }
    }
  }

}

