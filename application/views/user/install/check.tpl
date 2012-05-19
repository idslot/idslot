<form method="get" action="<?php echo site_url('install/database') ?>">

  <div class="form">
    <?php echo lang('check info'); ?><br /><br />
    <ul>
      <li style="color:<?php echo $database_config?'green':'red'; ?>;">application/config/database.php <?php echo lang('must be writable'); ?>.</li>
      <li style="color:<?php echo $compile_dir?'green':'red'; ?>;">application/views/idslot/ <?php echo lang('must be writable'); ?>.</li>
    </ul>
  </div>
    <div class="submit"><label></label>
<?php
if($database_config && $compile_dir){
  echo '<input type="submit" value="' . lang('Next') . '" class="form-submit" />';
}else{
  echo '<input type="button" value="' . lang('Refresh') . '" class="form-submit" id="refresh" />';
}
?>

</div>
</form>

