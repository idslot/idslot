<?php
$this->load->helper('url');
$base_url = base_url();
$this->load->helper('language');
$this->lang->load('idslot');
$this->lang->load('install');
$data = $this->form_validation->_field_data;

$username = array(
    'name' => 'username',
    'id' => 'username',
    'class' => 'ltr',
    'value' => set_value('username'),
    'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
    'size' => 30,
);

$email = array(
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'class' => 'ltr',
    'size' => 30,
);

$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'ltr',
    'value' => set_value('password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
$password_confirm = array(
    'name' => 'password_confirm',
    'id' => 'password_confirm',
    'class' => 'ltr',
    'value' => set_value('password_confirm'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
?>

<form method="post" action="<?php echo site_url('install/setup') ?>">

  <div class="form">
    <?php echo lang('setup info'); ?><br /><br />
  </div>
  <div class="form" title="<?php echo lang('Username Description'); ?>">
    <?php echo form_label(lang('Username') . ':', $username['id']); ?><?php echo form_input($username); ?>
  </div>
  <div class="form">
    <?php echo form_label(lang('Email') . ':', $email['id']); ?><?php echo form_input($email); ?>
  </div>

  <div class="form">
    <?php echo form_label(lang('Password') . ':', $password['id']); ?><?php echo form_password($password); ?>
  </div>

  <div class="form">
    <?php echo form_label(lang('Password Confirm') . ':', $password_confirm['id']); ?><?php echo form_password($password_confirm); ?>
  </div>
  <div class="submit"><label></label>
    <input type="submit" name="submit" value="<?php echo lang('Next'); ?>" class="form-submit" />
  </div>
</form>

