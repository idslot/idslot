<div id="about" class="panel">
	<span class="ptitle block"><?php print($title); ?></span>
	<span class="content block">
          <a title="<?php print($title); ?>" href="application/views/idslot/files/about/<?php echo $uid;?>.png" class="photo"><img alt="<?php print($title); ?>" src="application/views/idslot/files/about/thumb_<?php echo $uid;?>.png" style="float: left; margin: 7px;" /></a>
        <?php print(nl2br(strip_tags($content))); ?></span>
</div>