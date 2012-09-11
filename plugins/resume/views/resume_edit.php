<?php
$this->load->helper('url');
$this->load->model('plugin');
$this->plugin->model('resume');
$urn_types = array(
	'IETF' => 'IETF',
	'ISBN' => 'ISBN',
	'ISSN' => 'ISSN'
);
$data = $this->form_validation->_field_data;
?>
<form id="mainform" action="" method="post">

  <div class="form <?php echo $this->system->is_required($data, 'resume[summary]'); ?>" title="<?php echo lang('Resume Summary Description'); ?>">
    <label><?php echo lang('Summary'); ?>:</label><textarea name="resume[summary]" cols="50" class="form-textarea"><?php echo $summary; ?></textarea>
  </div>
  <div class="submit">
	<label></label>
        <input type="submit" value="<?php echo lang('Submit');?>" class="form-submit" />
        <input type="button" onclick="parent.location='<?php echo site_url('plugins/resume/build_pdf'); ?>'" value="<?php echo lang('Build pdf');?>" class="form-submit" />
        <input type="button" onclick="parent.location='<?php echo site_url('plugins/resume/remove_pdf'); ?>'" value="<?php echo lang('Remove pdf');?>" class="form-delete" />
  </div>

</form>

<h3 class="title"><?php echo lang('Skills'); ?></h3><hr>
<ul id="skills" class="style1 ui-sortable">
	<?php
	foreach($skills as $skill){
	?>
  <li id="skills_<?php echo $skill['id']; ?>" class="ui-state-default">
		<?php
		echo sprintf('<div id="%d-skill" class="li"><a href="%s" onclick="$(\'#%d-skill\').slideUp(); $(\'#%d-skill-form\').slideDown();return false;">%s</a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>',
			$skill['id'],
			site_url('plugins/resume/edit_skill/' . $skill['id']),
			$skill['id'],
			$skill['id'],
			$skill['title']
		);
		echo form_open_multipart('plugins/resume/edit_skill/' . $skill['id']); 
		?>
		  <div class="subfieldset SkillDiv" style="display:none;" id="<?php echo $skill['id'] . '-skill-form'; ?>">
			
			<h2 class="delete"><a href="#" onclick="$('#<?php echo $skill['id'];?>-skill').slideDown();$('#<?php echo $skill['id'];?>-skill-form').slideUp(); return false;"></a></h2>
			
			<div class="form required" title="<?php echo lang('Skill Title Description'); ?>">
			  <label><?php echo lang('Title'); ?>:</label><input type="text" class="skill" name="title"  value="<?php echo $skill['title'];?>"/>
			</div>
			<div class="submit">
				<label></label><a class="button form-delete" href="<?php echo site_url('plugins/resume/remove_skill/' . $skill['id']) ?>" onclick="return confirm('<?php echo lang('Are you sure to delete this skill?') ?>');"><?php echo lang('Delete'); ?></a><input type="submit" name="submit" value="<?php echo lang('Edit'); ?>" class="form-submit" />
			</div>
			
		  </div>
		</form>
	</li>
	<?php
	}
	?>
</ul>
<?php
echo form_open_multipart('plugins/resume/add_skill/'); 
?>

  <h4 class="subtitle"><?php echo lang('Add skill'); ?></h4>
  <div class="form required" title="<?php echo lang('Skill Title Description'); ?>">
    <label><?php echo lang('Title'); ?>:</label><input type="text" class="skill" name="title" value=""/>
  </div>
  <div class="submit">
    <label></label><input type="submit" name="submit" value="<?php echo lang('Add'); ?>" class="form-submit" />
  </div>

</form>


<h3 class="title"><?php echo lang('Educations'); ?></h3><hr>
<ul id="educations" class="style1 ui-sortable">
	<?php
	foreach($educations as $education){
	?>
    <li id="educations_<?php echo $education['id']; ?>" class="ui-state-default">
		<?php
		echo sprintf('<div id="%d-education" class="li"><a href="%s" onclick="$(\'#%d-education\').slideUp(); $(\'#%d-education-form\').slideDown();return false;">%s</a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>',
			$education['id'],
			site_url('plugins/resume/edit_education/' . $education['id']),
			$education['id'],
			$education['id'],
			$education['summary']
		);
		echo form_open_multipart('plugins/resume/edit_education/' . $education['id']); 
		?>
		<div class="subfieldset EduDiv" style="display:none;" id="<?php echo $education['id'] . '-education-form'; ?>">
		
		<h2 class="delete"><a href="#" onclick="$('#<?php echo $education['id'];?>-education').slideDown();$('#<?php echo $education['id'];?>-education-form').slideUp(); return false;"></a></h2>
		
		<div class="form required" title="<?php echo lang('Education Summary Description'); ?>">
		  <label><?php echo lang('Summary'); ?>:</label><input type="text" class="inp-form" name="summary" value="<?php echo $education['summary'];?>"/>
		</div>
		<div class="form <?php echo $this->system->is_required($data, 'description'); ?>" title="<?php echo lang('Education Description Description'); ?>">
		  <label><?php echo lang('Description'); ?>:</label><textarea name="description" cols="50" class="form-textarea"><?php echo $education['description'];?></textarea>
		</div>
		<div class="form required" title="<?php echo lang('Education Start Description'); ?>">
		  <label><?php echo lang('Start'); ?>:</label><input type="text" class="inp-form datepicker0" name="start" value="<?php echo $education['start'];?>"/>
		</div>
		<div class="form required" title="<?php echo lang('Education End Description'); ?>">
		  <label><?php echo lang('End'); ?>:</label><input type="text" class="inp-form datepicker0" name="end" value="<?php echo $education['end'];?>"/>
		</div>
		<div class="submit">
			<label></label><a class="button form-delete" href="<?php echo site_url('plugins/resume/remove_education/' . $education['id']) ?>" onclick="return confirm('<?php echo lang('Are you sure to delete this education?') ?>');"><?php echo lang('Delete'); ?></a><input type="submit" name="submit" value="<?php echo lang('Edit'); ?>" class="form-submit" />
		</div>
		
		</div>
		</form>
	</li>
	<?php
	}
	?>
</ul>
<?php
echo form_open_multipart('plugins/resume/add_education/'); 
?>


  <h4 class="subtitle"><?php echo lang('Add education'); ?></h4>
  <div class="form required" title="<?php echo lang('Education Summary Description'); ?>">
    <label><?php echo lang('Summary'); ?>:</label><input type="text" class="inp-form" name="summary" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'description'); ?>" title="<?php echo lang('Education Description Description'); ?>">
    <label><?php echo lang('Description'); ?>:</label><textarea name="description" cols="50" class="form-textarea"></textarea>
  </div>
  <div class="form required" title="<?php echo lang('Education Start Description'); ?>">
    <label><?php echo lang('Start'); ?>:</label><input type="text" class="inp-form datepicker0" name="start" value=""/>
  </div>
  <div class="form required" title="<?php echo lang('Education End Description'); ?>">
    <label><?php echo lang('End'); ?>:</label><input type="text" class="inp-form datepicker0" name="end" value=""/>
  </div>
  <div class="submit">
    <label></label><input type="submit" name="submit" value="<?php echo lang('Add'); ?>" class="form-submit" />
  </div>

</form>



<h3 class="title"><?php echo lang('Experiences'); ?></h3><hr>
<ul id="experiences" class="style1 ui-sortable">
	<?php
	foreach($experiences as $experience){
	?>
	<li id="experiences_<?php echo $experience['id']; ?>" class="ui-state-default">
		<?php
		echo sprintf('<div id="%d-experience" class="li"><a href="%s" onclick="$(\'#%d-experience\').slideUp(); $(\'#%d-experience-form\').slideDown();return false;">%s</a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>',
			$experience['id'],
			site_url('plugins/resume/edit_experience/' . $experience['id']),
			$experience['id'],
			$experience['id'],
			$experience['summary']
		);
		echo form_open_multipart('plugins/resume/edit_experience/' . $experience['id']); 
		?>
		<div class="subfieldset ExpDiv" style="display:none;" id="<?php echo $experience['id'] . '-experience-form'; ?>">
		
		<h2 class="delete"><a href="#" onclick="$('#<?php echo $experience['id'];?>-experience').slideDown();$('#<?php echo $experience['id'];?>-experience-form').slideUp(); return false;"></a></h2>
		
		<div class="form required" title="<?php echo lang('Experience Summary Description'); ?>">
		  <label><?php echo lang('Summary'); ?>:</label><input type="text" class="inp-form" name="summary" value="<?php echo $experience['summary'];?>"/>
		</div>
		<div class="form required" title="<?php echo lang('Experience Category Description'); ?>">
		  <label><?php echo lang('Category'); ?>:</label>
		      <select class="parent-cat" onchange="change_subcat(this.value, <?php echo $experience['id']; ?>);">
		      <?php
		      $parent_category = $this->resume->find_parent($experience['category_id']);
		      $parent_categories = $this->resume->fetch_event_parent_categories();
		      foreach($parent_categories as $p){
			      echo '<option value="' . $p['id'] . '"' . ($parent_category==$p['id']?' selected="selected"':'') . '>' . lang($p['title']) . '</option>';
		      }
		      ?>
		      </select>
		</div>
		<div class="form required" title="<?php echo lang('Experience Subcategory Description'); ?>">
		  <label><?php echo lang('Subcategory'); ?>:</label>
		      <?php
		      reset($parent_categories);
		      foreach($parent_categories as $p){
			      $child_categories = $this->resume->fetch_event_child_categories($p['id']);
		      ?>
		      <select name="<?php echo $parent_category==$p['id']?'category':'category0'; ?>" id="<?php echo $experience['id']; ?>-cat-<?php echo $p['id']; ?>" <?php echo $parent_category!=$p['id']?'style="display:none"':''?>>
		      <?php
		      foreach($child_categories as $c){
			      echo '<option value="' . $c['id'] . '"' . ($experience['category_id']==$c['id']?' selected="selected"':'') . '>' . lang($c['title']) . '</option>';
		      }
		      ?>
		      </select>
		      <?php
		      }
		      ?>
		</div>
		<div class="form required" title="<?php echo lang('Experience Description Description'); ?>">
		  <label><?php echo lang('Description'); ?>:</label><textarea name="description" cols="50" class="form-textarea"><?php echo $experience['description'];?></textarea>
		</div>
		<div class="form required" title="<?php echo lang('Experience Start Description'); ?>">
		  <label><?php echo lang('Start'); ?>:</label><input type="text" class="inp-form  datepicker0" name="start" value="<?php echo $experience['start'];?>"/>
		</div>
		<div class="form required" title="<?php echo lang('Experience End Description'); ?>">
		  <label><?php echo lang('End'); ?>:</label><input type="text" class="inp-form datepicker0" name="end" value="<?php echo $experience['end'];?>"/>
		</div>
		<div class="submit">
			<label></label><a class="button form-delete" href="<?php echo site_url('plugins/resume/remove_experience/' . $experience['id']) ?>" onclick="return confirm('<?php echo lang('Are you sure to delete this experience?') ?>');"><?php echo lang('Delete'); ?></a><input type="submit" name="submit" value="<?php echo lang('Edit'); ?>" class="form-submit" />
		</div>
		</div>
		</form>
	</li>
	<?php
	}
	?>
</ul>
<?php
echo form_open_multipart('plugins/resume/add_experience/'); 
?>


  <h4 class="subtitle"><?php echo lang('Add experience'); ?></h4>
  <div class="form required" title="<?php echo lang('Experience Summary Description'); ?>">
    <label><?php echo lang('Summary'); ?>:</label><input type="text" class="inp-form" name="summary" value=""/>
  </div>
  <div class="form required" title="<?php echo lang('Experience Category Description'); ?>">
    <label><?php echo lang('Category'); ?>:</label>
	<select class="parent-cat" onchange="change_subcat(this.value, '');">
	<?php
	$parent_categories = $this->resume->fetch_event_parent_categories();
	foreach($parent_categories as $p){
		echo '<option value="' . $p['id'] . '">' . lang($p['title']) . '</option>';
	}
	?>
	</select>
  </div>
  <div class="form required" title="<?php echo lang('Experience Subcategory Description'); ?>">
    <label><?php echo lang('Subcategory'); ?>:</label>
	<?php
	foreach($parent_categories as $p){
		$child_categories = $this->resume->fetch_event_child_categories($p['id']);
	?>
	<select name="category" id="cat-<?php echo $p['id']; ?>">
	<?php
	foreach($child_categories as $c){
		echo '<option value="' . $c['id'] . '">' . lang($c['title']) . '</option>';
	}
	?>
	</select>
	<?php
	}
	?>
  </div>
  <script>
	function change_subcat(catid, expid){
		if(expid) expid = expid + '-';
		if(catid) catid = '-' + catid;
		$('select[id^="' + expid + 'cat"]').css('display', 'none');
		$('select[id^="' + expid + 'cat"]').attr('name','category0');
		$('#' + expid + 'cat' + catid).css('display', 'inline');
		$('#' + expid + 'cat' + catid).attr('name','category');
	}
	
	function hide_all_subcats(){
		$('select[id^="cat"]').css('display', 'none');
		$('select[id^="cat"]').attr('name','category0');
		$('select[id^="cat"]:first').css('display', 'inline');
		$('select[id^="cat"]:first').attr('name','category');
	}
	
	window.onload = hide_all_subcats();
  </script>
  <div class="form <?php echo $this->system->is_required($data, 'description'); ?>" title="<?php echo lang('Experience Description Description'); ?>">
    <label><?php echo lang('Description'); ?>:</label><textarea name="description" cols="50" class="form-textarea"></textarea>
  </div>
  <div class="form required" title="<?php echo lang('Experience Start Description'); ?>">
    <label><?php echo lang('Start'); ?>:</label><input type="text" class="inp-form  datepicker0" name="start" value=""/>
  </div>
  <div class="form required" title="<?php echo lang('Experience End Description'); ?>">
    <label><?php echo lang('End'); ?>:</label><input type="text" class="inp-form datepicker0" name="end" value=""/>
  </div>
  <div class="submit">
    <label></label><input type="submit" name="submit" value="<?php echo lang('Add'); ?>" class="form-submit" />
  </div>

</form>




<h3 class="title"><?php echo lang('Publications'); ?></h3><hr>
<ul id="publications" class="style1 ui-sortable">
	<?php
	foreach($publications as $publication){
	?>
	<li id="publications_<?php echo $publication['id']; ?>" class="ui-state-default">
		<?php
		echo sprintf('<div id="%d-publication" class="li"><a href="%s" onclick="$(\'#%d-publication\').slideUp(); $(\'#%d-publication-form\').slideDown();return false;">%s</a><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>',
			$publication['id'],
			site_url('plugins/resume/edit_publication/' . $publication['id']),
			$publication['id'],
			$publication['id'],
			$publication['title']
		);
		echo form_open_multipart('plugins/resume/edit_publication/' . $publication['id']); 
		?>
		<div class="subfieldset PubDiv" style="display:none;" id="<?php echo $publication['id'] . '-publication-form'; ?>">
		
		<h2 class="delete"><a href="#" onclick="$('#<?php echo $publication['id'];?>-publication').slideDown();$('#<?php echo $publication['id'];?>-publication-form').slideUp(); return false;"></a></h2>
		
		<div class="form required" title="<?php echo lang('Publication Title Description'); ?>">
		  <label><?php echo lang('Title'); ?>:</label><input type="text" class="inp-form" name="title" value="<?php echo $publication['title'];?>"/>
		</div>
		<div class="form required" title="<?php echo lang('Publication Creators Description'); ?>">
		  <label><?php echo lang('Creators'); ?>:</label><input type="text" class="inp-form" name="creators" value="<?php echo $publication['creators'];?>"/>
		</div>
		<div class="form <?php echo $this->system->is_required($data, 'publisher'); ?>" title="<?php echo lang('Publication Publisher Description'); ?>">
		  <label><?php echo lang('Publisher'); ?>:</label><input type="text" class="inp-form" name="publisher" value="<?php echo $publication['publisher'];?>"/>
		</div>
		<div class="form required" title="<?php echo lang('Publication Date Description'); ?>">
		  <label><?php echo lang('Date'); ?>:</label><input type="text" class="inp-form datepicker0" name="date" value="<?php echo $publication['date'];?>"/>
		</div>
		<div class="form <?php echo $this->system->is_required($data, 'urn'); ?>" title="<?php echo lang('Publication URN Description'); ?>">
		  <label><?php echo lang('URN'); ?>:</label><input type="text" class="inp-form" name="urn" value="<?php echo $publication['urn'];?>"/>
		</div>
		<div class="form <?php echo $this->system->is_required($data, 'urn_type'); ?>" title="<?php echo lang('Publication URN type Description'); ?>">
		  <label><?php echo lang('URN type'); ?>:</label>
		      <?php
		      echo form_dropdown('urn_type', $urn_types, $publication['urn_type']);
		      ?>
		</div>
		<div class="submit">
			<label></label><a class="button form-delete" href="<?php echo site_url('plugins/resume/remove_publication/' . $publication['id']) ?>" onclick="return confirm('<?php echo lang('Are you sure to delete this publication?') ?>');"><?php echo lang('Delete'); ?></a><input type="submit" name="submit" value="<?php echo lang('Edit'); ?>" class="form-submit" />
		</div>
		
		</div>
		</form>
	</li>
	<?php
	}
	?>
</ul>
<?php
echo form_open_multipart('plugins/resume/add_publication/'); 
?>


  <h4 class="subtitle"><?php echo lang('Add publication'); ?></h4>
  <div class="form required" title="<?php echo lang('Publication Title Description'); ?>">
    <label><?php echo lang('Title'); ?>:</label><input type="text" class="inp-form" name="title" value=""/>
  </div>
  <div class="form required" title="<?php echo lang('Publication Creators Description'); ?>">
    <label><?php echo lang('Creators'); ?>:</label><input type="text" class="inp-form" name="creators" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'publisher'); ?>" title="<?php echo lang('Publication Publisher Description'); ?>">
    <label><?php echo lang('Publisher'); ?>:</label><input type="text" class="inp-form" name="publisher" value=""/>
  </div>
  <div class="form required" title="<?php echo lang('Publication Date Description'); ?>">
    <label><?php echo lang('Date'); ?>:</label><input type="text" class="inp-form datepicker0" name="date" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'urn'); ?>" title="<?php echo lang('Publication URN Description'); ?>">
    <label><?php echo lang('URN'); ?>:</label><input type="text" class="inp-form" name="urn" value=""/>
  </div>
  <div class="form <?php echo $this->system->is_required($data, 'urn_type'); ?>" title="<?php echo lang('Publication URN type Description'); ?>">
    <label><?php echo lang('URN type'); ?>:</label>
	<?php
	echo form_dropdown('urn_type', $urn_types);
	?>
  </div>
  <div class="submit">
    <label></label><input type="submit" name="submit" value="<?php echo lang('Add'); ?>" class="form-submit" />
  </div>

</form>
