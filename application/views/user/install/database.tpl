<?php
$this->load->helper('url');
$base_url = base_url();
$data = $this->form_validation->_field_data;
?>
<form method="post" action="<?php echo site_url('install/database') ?>">

  <div class="form">
    <?php echo lang('database info'); ?><br /><br />
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'db_host'); ?>" title="<?php echo lang('Database host description'); ?>">
    <label><?php echo lang('Database host'); ?>:</label><input type="text" class="inp-form" name="db_host" value="<?php echo set_value('db_host'); ?>" />
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'db_name'); ?>" title="<?php echo lang('Database name description'); ?>">
    <label><?php echo lang('Database name'); ?>:</label><input type="text" class="inp-form" name="db_name" value="<?php echo set_value('db_name'); ?>" />
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'db_user'); ?>" title="<?php echo lang('Database username description'); ?>">
    <label><?php echo lang('Database username'); ?>:</label><input type="text" class="inp-form" name="db_user" value="<?php echo set_value('db_user'); ?>" />
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'db_pass'); ?>" title="<?php echo lang('Database password description'); ?>">
    <label><?php echo lang('Database password'); ?>:</label><input type="password" class="inp-form" name="db_pass" />
  </div>
  <div class="submit"><label></label>
    <input type="submit" name="submit" value="<?php echo lang('Next'); ?>" class="form-submit" />
  </div>
</form>

