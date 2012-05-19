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
class Install extends CI_Controller {

  private $steps = array('check', 'database', 'setup', 'success');

  public function __construct() {
    parent::__construct();

    $this->load->helper(array('form', 'url'));
    $this->load->library(array('form_validation', 'security', 'session'));
    $this->load->model('system');
    $this->lang->load('idslot');
    $this->lang->load('install');

    include(APPPATH . 'config/database.php');
    if ($db['default']['hostname'] != '' && !$this->session->userdata('install')) {
      $this->system->add_msg(lang('Idslot already installed!'));
      redirect('auth/login');
      exit();
    } elseif ($db['default']['hostname'] == '') {
      $this->session->set_userdata(array('install' => true));
    }
  }

  public function index() {
    $data['steps'] = $this->steps;
    $data['current_step'] = 'check';

    $data['compile_dir'] = is_writable(APPPATH . "views/idslot/");
    $data['config_config'] = is_writable(APPPATH . "config/config.php");
    $data['database_config'] = is_writable(APPPATH . "config/database.php");

    $this->load->view('user/install.tpl', $data);
  }

  public function database() {
    $data['steps'] = $this->steps;
    $data['current_step'] = 'database';

    $config = array(
        array(
            'field' => 'db_host',
            'label' => lang('Database host'),
            'rules' => 'required|alpha_dash|xss_clean'
        ),
        array(
            'field' => 'db_name',
            'label' => lang('Database name'),
            'rules' => 'required|alpha_dash|xss_clean'
        ),
        array(
            'field' => 'db_user',
            'label' => lang('Database username'),
            'rules' => 'required|alpha_dash|xss_clean'
        ),
        array(
            'field' => 'db_pass',
            'label' => lang('Database password'),
            'rules' => 'required|alpha_dash|xss_clean'
        )
    );
    $this->form_validation->set_rules($config);
    if ($this->form_validation->run()) {
      $vars = array("\$db['default']['hostname']",
          "\$db['default']['username']",
          "\$db['default']['password']",
          "\$db['default']['database']");
      $vals = array($this->input->post('db_host'),
          $this->input->post('db_user'),
          $this->input->post('db_pass'),
          $this->input->post('db_name'));
      $link = @mysql_connect($this->input->post('db_host'), $this->input->post('db_user'), $this->input->post('db_pass'));
      if (@mysql_select_db($this->input->post('db_name'), $link)) {

        mysql_query('ALTER DATABASE `' . $this->input->post('db_name') . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci', $link);
        $this->import_sql('sql/idslot_mysql.sql', $link);
        @mysql_close();
        $this->set_var('config/database.php', $vars, $vals);
        redirect('install/setup');
      } else {
        $data['errors'][] = lang('Unable to connect to your database server');
      }
    } else {
      $this->form_validation->set_error_delimiters('', '<br />');
      $data['errors'][] = validation_errors();
    }
    $this->load->view('user/install.tpl', $data);
  }

  public function setup() {
    $this->load->database();
    $data['steps'] = $this->steps;
    $data['current_step'] = 'setup';

    $config = array(
        array(
            'field' => 'title',
            'label' => lang('Title'),
            'rules' => 'required|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => lang('Username'),
            'rules' => 'trim|required|xss_clean|alpha_dash'
        ),
        array(
            'field' => 'email',
            'label' => lang('Email'),
            'rules' => 'trim|required|xss_clean|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => lang('Password'),
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'password_confirm',
            'label' => lang('Password Confirm'),
            'rules' => 'trim|required|xss_clean|matches[password]'
        )
    );
    $this->form_validation->set_rules($config);
    if ($this->form_validation->run()) {     // validation ok
      $this->load->library('tank_auth');
      $this->lang->load('tank_auth');
      if (!is_null($udata = $this->tank_auth->create_user(
                      $this->form_validation->set_value('username'), $this->form_validation->set_value('email'), $this->form_validation->set_value('password'), $this->form_validation->set_value('title'), '', 'default', $this->config->item('language'), '', ''))) {    // success
        $this->load->model('system');

        $plugins = $this->config->item('plugins');

        //Add resume to plugins as external plugin
        $plugins['resume'] = 'Resume';

        //Create plugins
        foreach ($plugins as $pname => $pmodel) {
          $this->load->model('plugins/' . $pmodel);
          $this->$pmodel->create($udata['user_id'], false);
        }
        $this->system->render($udata['user_id']);
        $this->session->unset_userdata('install');
        $data['current_step'] = 'success';
      } else {
        $errors = $this->tank_auth->get_error_message();
        foreach ($errors as $k => $v)
          $data['errors'][$k] = $this->lang->line($v);
      }
    } else {
      $this->form_validation->set_error_delimiters('', '<br />');
      $data['errors'][] = validation_errors();
    }

    $this->load->view('user/install.tpl', $data);
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
    }
    $content = preg_replace($var, $val, $content);
    file_put_contents(APPPATH . $file, $content);
    return true;
  }

  private function import_sql($file, $link) {
    $query = '';
    $lines = file(APPPATH . $file);
    foreach ($lines as $line) {
      $line = trim($line);
      if (strpos($line, '-') !== 0 && strlen($line)) {
        $query .= $line;
      }

      if (strrpos($line, ';') === strlen($line) - 1) {
        mysql_query($query, $link);
        $query = '';
      }
    }
  }

}

