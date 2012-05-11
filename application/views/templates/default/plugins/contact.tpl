

<div id="contact" class="panel">
	<span class="ptitle block"><?php print($title); ?></span>
	<div class="info">
		<span class="description block"><?php print($description); ?></span>
		<?php
			if($email && filter_var(strip_tags($email), FILTER_VALIDATE_EMAIL)){
			  echo "<div><div class=\"infoTitle\">" . lang('Email') . ":</div><a href=\"mailto:{$email}\" class=\"email\" target=\"_blank\">{$email}</a></div>";
			}
			if($tel){
				echo "<div class=\"tel\"><div class=\"infoTitle\">" . lang('Telephone') . ":</div><span class=\"type\">work</span><span class=\"value\">" . $tel . "</span></div>";
			}
			if($fax){
				echo "<div class=\"tel\"><div class=\"infoTitle\">" . lang('Fax') . ":</div><span class=\"type\">fax</span><span class=\"value\">" . $fax . "</span></div>";
			}
			if($mob){
				echo "<div class=\"tel\"><div class=\"infoTitle\">" . lang('Cellphone') . ":</div><span class=\"type\">cell</span><span class=\"value\">" . $mob . "</span></div>";
			}
			if($website && filter_var(strip_tags($website), FILTER_VALIDATE_URL)){
				echo "<div><div class=\"infoTitle\">" . lang('Web Site') . ":</div>" . $website . "</div>";
			}
			if($weblog && filter_var(strip_tags($weblog), FILTER_VALIDATE_URL)){
				echo "<div><div class=\"infoTitle\">" . lang('Weblog') . ":</div>" . $weblog . "</div>";
			}
			if($address){
				echo "<div><div class=\"infoTitle\">" . lang('Address') . ":</div><span class=\"adr\"><span class=\"street-address\">" . nl2br(strip_tags($address)) . "</span></span></div>";
			}
			if($postcode){
				echo "<div><div class=\"infoTitle\">" . lang('Postcode') . ":</div>" . $postcode . "</div>";
			}
		?>
	</div>

<?php if(lang('direction') == 'rtl'){ ?>
	<script type="text/javascript">
		$('.info div').hover(function () {
			$('div', this).stop().animate({
				marginRight : 5
			}, 250);
		}, function() {
			$('div', this).stop().animate({
				marginRight : 0
			}, 250);
		});
	</script>
<?php }else{ ?>
	<script type="text/javascript">
		$('.info div').hover(function () {
			$('div', this).stop().animate({
				marginLeft : 5
			}, 250);
		}, function() {
			$('div', this).stop().animate({
				marginLeft : 0
			}, 250);
		});
	</script>
<?php } ?>

	<div class="form">
		<?php
		if($map){
			$tmap = $map;
			$pattern = '/http:\/\/maps.google.com\/maps\/api\/staticmap\?center=([\d.-]+),([\d.-]+)&zoom=10&size=\d+x\d+&maptype=roadmap&sensor=false&language=..markers=color:\w+\|([\d.-]+),([\d.-]+)/';
			$matches = '';
			if(preg_match($pattern, $map, $matches)){
				$tmap = str_replace($matches[1], $matches[3], $tmap);
				$tmap = str_replace($matches[2], $matches[4], $tmap);
			}
			$tmap = str_replace('size=400x300', 'size=252x70', $tmap);
			$tmap = str_replace('color:red', 'color:red|size:small', $tmap);
			$tmap = str_replace('&', '&amp;', $tmap);
			$map = str_replace('&', '&amp;', $map);
			
			echo '<a href="'.$map.'&amp;.png" class="map"><img src="'.$tmap.'" id="map" class="map" /></a>';
		}
		?>
		<form action="contact.php" method="post">
			<span class="block"><label for="name"><?php echo lang('Name'); ?></label><input type="text" name="name" id="name" /></span>
			<span class="block"><label for="email"><?php echo lang('Email'); ?></label><input type="text" name="email" id="email" /></span>
			<span class="block"><label for="msg"><?php echo lang('Message'); ?></label><textarea name="message" id="msg"></textarea></span>
			
			<span class="captcha"><img src="<?php echo $this->config->item('base_url'); ?>index.php?/captcha/generate/<?php echo md5($uid); ?>" class="captcha" /></span>
			<span><label class="captcha" for="captcha"><?php echo lang('Confirmation Code'); ?></label><input type="text" name="captcha" id="captcha"/></span>
			
			<span class="submit"><input type="submit" name="submit" class="button" id="submit_btn" value="<?php echo lang('Send'); ?>..."/></span>
		</form>		
	</div>
	<div class="clear-both"></div>
</div>