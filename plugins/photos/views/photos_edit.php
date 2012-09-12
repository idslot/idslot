<?php
$data = $this->form_validation->_field_data;
?>
<form id="mainform" action="" method="post">
  <div class="form <?php echo $this->system->is_required($data, 'photos[title]'); ?>" title="<?php echo lang('Photos Title Description'); ?>">
    <label><?php echo lang('Title'); ?>:</label><input type="text" class="inp-form" name="photos[title]" value="<?php echo $title; ?>"/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'photos[description]'); ?>" title="<?php echo lang('Photos Description Description'); ?>">
    <label><?php echo lang('Description'); ?>:</label><textarea name="photos[description]" cols="50" class="form-textarea"><?php echo $description; ?></textarea>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'photos[visible]'); ?>" title="<?php echo lang('Visible Description');?>">
    <label><?php echo lang('Visibility');?>:</label>
    <select name="photos[visible]">
      <option value="1"<?php echo $visible==1?' selected':''; ?>><?php echo lang('Show'); ?></option>
      <option value="0"<?php echo $visible==0?' selected':''; ?>><?php echo lang('Hide'); ?></option>
    </select>
  </div>
  <div class="submit">
    	<label></label><input type="submit" value="<?php echo lang('Submit');?>" class="form-submit" />
  </div>
</form>
</div>
<div class="rightpad mainbox">
<h3 class="title"><?php echo lang('Photos'); ?></h3><hr>
<p><?php echo lang('How to edit'); ?></p>
<ul id="photos" class="style1 ui-sortable">
<?php
$web = base_url() . "views/idslot/files/photos/thumb_";
foreach($photoss as $photos){
?>

	
	<li id="photos_<?php echo $photos['id']; ?>" class="ui-state-default">
<?php
echo sprintf('<div id="%d-link"><a href="%s" onclick="$(\'#%d-link\').slideUp(); $(\'#%d-link-form\').slideDown();return false;"><div><img src="%s" class="photosimg"/></div>%s</a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>', $photos['id'], site_url('plugins/photos/edit/' . $photos['id']), $photos['id'], $photos['id'], $web . $uid . '-' . $photos['id'] . '.png?' . rand(10, 99), $photos['content']);
echo form_open_multipart('plugins/photos/edit/' . $photos['id']); 
?>

  <div class="subfieldset PhotosDiv" style="display:none;" id="<?php echo $photos['id'] . '-link-form'; ?>">
	
	<h2 class="delete"><a href="#" onclick="$('#<?php echo $photos['id'];?>-link').slideDown();$('#<?php echo $photos['id'];?>-link-form').slideUp(); return false;"></a></h2>
	
  <div class="form" title="<?php echo lang('Photos text description'); ?>">
    <label><?php echo lang('Content'); ?>:</label><textarea name="content" cols="50" class="form-textarea tinymce"><?php echo $photos['content']; ?></textarea>
  </div>
  <div class="form" title="<?php echo lang('Photos image'); ?>">
    <label><?php echo lang('Image'); ?>:</label><input type="file" name="photos_file" class="file_1"/>
  </div>
  <div class="form">
    <label>&nbsp;</label><img src="<?php echo $web . $uid . '-' . $photos['id'] . '.png?' . rand(10, 99); ?>" />
  </div>
  <div>
		<label></label><a class="button form-delete" href="<?php echo site_url('/plugins/photos/remove/' . $photos['id']) ?>" onclick="return confirm('<?php echo lang('Are you sure to delete this work?') ?>');"><?php echo lang('Delete'); ?></a><input type="submit" name="submit" value="<?php echo lang('Edit'); ?>" class="form-submit" />
  </div>
	
  </div>
</form>
</li>


<?php
}
?>
</ul>

<?php  
echo form_open_multipart('plugins/photos/add/' . $id); 
?>

<h4 class="subtitle"><?php echo lang('Add a new photos'); ?></h4>
  <div class="form required" title="<?php echo lang('Photos text description'); ?>">
    <label><?php echo lang('Content'); ?>:</label><textarea name="content" cols="50" class="form-textarea"></textarea>
  </div>
  <div class="form required" title="<?php echo lang('Photos image'); ?>">
    <label><?php echo lang('Image'); ?>:</label><input type="file" name="photos_file" class="file_1"/>
  </div>
  <div class="submit">
    <label></label><input type="submit" name="submit" value="<?php echo lang('Add'); ?>" class="form-submit" />
  </div>

</form>