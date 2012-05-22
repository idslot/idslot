<div id="photos" class="panel">
	<span class="ptitle block"><?php print($title); ?></span>
	<span class="description block"><?php print($description); ?></span>
		<ul class="photos">
			<?php
			foreach($photoss as $photos){
				echo '<li><a class="photos" rel="group1" title="'.$photos['content'].'" href="views/idslot/files/photos/' . $uid . '-' . $photos['id'] . '.png"><img alt="'.$photos['content'].'" src="views/idslot/files/photos/thumb_' . $uid . '-' . $photos['id'] . '.png" /></a></li>' . "\n";
			}
			?>
		</ul>
</div>