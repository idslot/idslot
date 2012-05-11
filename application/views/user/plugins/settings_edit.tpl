<?php
$data = $this->form_validation->_field_data;
?>
<form id="mainform" action="" method="post">

  <div class="form <?php echo $this->system->is_required($data, 'settings[email]'); ?>" title="<?php echo lang('Email Desc'); ?>">
    <label><?php echo lang('Email'); ?></label><input type="text" class="inp-form" name="settings[email]" value="<?php echo $email; ?>"/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'settings[old_password]'); ?>">
    <label><?php echo lang('Old Password'); ?>:</label><input type="password" class="inp-form" name="settings[old_password]" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'settings[new_password]'); ?>" title="<?php echo lang('Password Desc'); ?>">
    <label><?php echo lang('New Password'); ?>:</label><input type="password" class="inp-form" name="settings[new_password]" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'settings[confirm_password]'); ?>" title="<?php echo lang('Password Desc'); ?>">
    <label><?php echo lang('New Password Confirm'); ?>:</label><input type="password" class="inp-form" name="confirm_password" value=""/>
  </div>
  <div class="submit">
    <label></label><input type="submit" value="<?php echo lang('Submit');?>" class="form-submit" />
  </div>

</form>
