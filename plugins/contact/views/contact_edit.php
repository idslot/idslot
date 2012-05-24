<?php
$this->load->helper('url');
$base_url = base_url();
$data = $this->form_validation->_field_data;
?>
<h3 class="subtitle"><?php echo lang('Contact note'); ?></h3>
<script>
map_language = "<?php echo substr($language, 0, 2); ?>";
</script>
<script src="http://maps.google.com/maps/api/js?sensor=false&language=<?php echo $language; ?>" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>views/js/google.map.js" type="text/javascript"></script>
<form id="mainform" action="" method="post">

  <div class="form <?php echo $this->system->is_required($data, 'contact[title]'); ?>" title="<?php echo lang('Contact Title Description'); ?>">
    <label><?php echo lang('Title'); ?>:</label><input type="text" class="inp-form" name="contact[title]" value="<?php echo $title; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[description]'); ?>" title="<?php echo lang('Contact Description Description'); ?>">
    <label><?php echo lang('Description'); ?>:</label><textarea name="contact[description]" cols="50" class="form-textarea"><?php echo $description; ?></textarea>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'contact[email]'); ?>" title="<?php echo lang('Contact Email Description'); ?>">
    <label><?php echo lang('Contact Email'); ?></label><input type="text" class="ltr inp-form" name="contact[email]" value="<?php echo $email; ?>" />
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[tel]'); ?>" title="<?php echo lang('Contact Telephone Description'); ?>">
    <label><?php echo lang('Telephone'); ?>:</label><input type="text" class="ltr inp-form" name="contact[tel]" value="<?php echo $tel; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[fax]'); ?>" title="<?php echo lang('Contact Fax Description'); ?>">
    <label><?php echo lang('Fax'); ?>:</label><input type="text" class="ltr inp-form" name="contact[fax]" value="<?php echo $fax; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[mob]'); ?>" title="<?php echo lang('Contact Cellphone Description'); ?>">
    <label><?php echo lang('Cellphone'); ?>:</label><input type="text" class="ltr inp-form" name="contact[mob]" value="<?php echo $mob; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[website]'); ?>" title="<?php echo lang('Contact Website Description'); ?>">
    <label><?php echo lang('Web Site'); ?>:</label><input type="text" class="ltr inp-form" name="contact[website]" value="<?php echo $website?$website:'http://'; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[weblog]'); ?>" title="<?php echo lang('Contact Weblog Description'); ?>">
    <label><?php echo lang('Weblog'); ?>:</label><input type="text" class="ltr inp-form" name="contact[weblog]" value="<?php echo $weblog?$weblog:'http://'; ?>"/>
  </div>	    
  <div class="form" title="<?php echo lang('Contact Map Description'); ?>">
    <label><?php echo lang('Map'); ?>:
    <br/>(<a href="" onclick="reset_map(); return false;"><?php echo lang('Reset'); ?></a>)</label>
    <div id="map_canvas" class="map"></div>
    <input type="hidden" name="contact[map]" id="contact[map]" value="<?php echo $map; ?>">
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[address]'); ?>" title="<?php echo lang('Contact Address Description'); ?>">
    <label><?php echo lang('Address'); ?>:</label><textarea name="contact[address]" cols="50" class="form-textarea"><?php echo $address; ?></textarea>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[postcode]'); ?>" title="<?php echo lang('Contact Postcode Description'); ?>">
    <label><?php echo lang('Postcode'); ?>:</label><input type="text" class="ltr inp-form" name="contact[postcode]" value="<?php echo $postcode; ?>"/>
  </div>	    
  <div class="form <?php echo $this->system->is_required($data, 'contact[use_form]'); ?>" title="<?php echo lang('Use Form Description'); ?>">
    <label><?php echo lang('Use Form'); ?></label><input type="radio" name="contact[use_form]" value="1" <?php echo $use_form=='1'?'checked="checked"':'0'; ?> /><?php echo lang('Yes'); ?><input type="radio" name="contact[use_form]" value="0" <?php echo $use_form=='0'?'checked="checked"':'0'; ?> /><?php echo lang('No'); ?>
  </div>	
  <div class="form <?php echo $this->system->is_required($data, 'contact[visible]'); ?>" title="<?php echo lang('Visible Description');?>">
    <label><?php echo lang('Visibility');?>:</label>
    <select name="contact[visible]">
      <option value="1"<?php echo $visible==1?' selected':''; ?>><?php echo lang('Show'); ?></option>
      <option value="0"<?php echo $visible==0?' selected':''; ?>><?php echo lang('Hide'); ?></option>
    </select>
  </div>
  <div class="submit">
    <label></label><input type="submit" value="<?php echo lang('Submit');?>" class="form-submit" />
  </div>	    

</form>
