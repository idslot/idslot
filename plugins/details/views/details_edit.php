<?php
$this->load->helper('url');
$base_url = base_url();
$data = $this->form_validation->_field_data;
?>
<form id="mainform" action="<?php echo site_url('idslot/edit/details/1') ?>" method="post" enctype="multipart/form-data">

  <div class="form <?php echo $this->system->is_required($data, 'details[title]'); ?>" title="<?php echo lang('Title desc'); ?>">
    <label><?php echo lang('Title'); ?>:</label><input type="text" class="inp-form" name="details[title]" value="<?php echo $title; ?>"/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'details[short_description]'); ?>">
    <label><?php echo lang('Short Description'); ?>:</label><input type="text" class="inp-form" name="details[short_description]" value="<?php echo $short_description; ?>"/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'details[meta_keywords]'); ?>" title="<?php echo lang('Meta keyword desc'); ?>">
    <label><?php echo lang('Meta Keywords'); ?>:<br /><small>(<?php echo lang('comma separated'); ?>)</small></label><textarea name="details[meta_keywords]" cols="50" class="form-textarea"><?php echo $meta_keywords; ?></textarea>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'details[meta_description]'); ?>" title="<?php echo lang('Meta description desc'); ?>">
    <label><?php echo lang('Meta Description'); ?>:</label><textarea name="details[meta_description]" cols="50" class="form-textarea"><?php echo $meta_description; ?></textarea>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'details[template]'); ?>">
    <label><?php echo lang('Template'); ?>:</label>		<select id="details[template]" name="details[template]" onchange="change_template()">
		<?php
		$templates = $this->system->templates();
		foreach($templates as $tname=>$ttile){
		?>
		<option value="<?php echo $tname; ?>"<?php echo $tname==$template?' selected=selected':''; ?>><?php echo $ttile; ?></option>
		<?php
		}
		?>
		</select>
    <div class="form"><label></label>
			<img id="template_preview" src="">
			<script>
			function change_template(){
				var template = document.getElementById('details[template]').value;
				var template = '<?php echo $base_url; ?>views/templates/' + template + '/preview.jpg';
				document.getElementById('template_preview').src = template;
			}
			change_template();
			</script>
		</div>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'details[language]'); ?>">
    <label><?php echo lang('Language'); ?>:</label>
	<select name="details[language]">
	<?php
	$languages = $this->system->languages();
	foreach($languages as $lname=>$ltitle){
	?>
	<option value="<?php echo $lname; ?>"<?php echo $lname==$language?' selected=selected':''; ?>><?php echo $ltitle; ?></option>
	<?php
	}
	?>
	</select>
  </div>

  <div class="submit">
    <label></label><input type="submit" value="<?php echo lang('Submit');?>" class="form-submit" />
  </div>

</form>
