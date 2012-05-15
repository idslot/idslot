<?php
$web = base_url() . 'application/views/social_icons/';
?>
<div id="links" class="panel">
	<span class="ptitle block"><?php print($title); ?></span>
	<span class="description block"><?php print($description); ?></span>
		<ul class="links">
			<?php
				foreach($links as $link){
					echo '<li><a href="'. $link['url'] .'" title="' . $link['name'] . '" target="_blank"><img src="' . $web . $link['icon'] . '.png" class="float" alt="' . $link['name'] . '" /><span class="linkTitle block">' . $link['name'] .'</span><span class="address block">'. $link['url'] . '</span></a></li>' ."\n";
				}
			?>
		</ul>
</div>

<script type="text/javascript"> 
	$('.links a').hover(function () {
		$('img', this).stop().animate({
			'marginLeft' : 5
		}, 250);
	}, function() {
		$('img', this).stop().animate({
			'marginLeft' : 0
		}, 250);
	});
</script> 