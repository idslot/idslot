<?php 
$this->load->helper('url');
$base_url = base_url();
?>
<div style="font-size: 11px;">
  <h3>Your password in <?php echo $site_name; ?></h3>
Thanks for joining
  <?php echo $site_name; ?>  
We listed your sign in details below, make sure you keep them safe.
 <br />
 To open your <?php echo $site_name; ?> homepage, please follow this link:<br />
 <br />
<b><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;">Go to  <?php echo $site_name; ?></a></b><br /> 
  Link doesn't work? Copy the following link to your browser address bar:<br />
  <br />
<nobr><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;"><?php echo site_url('/auth/login/'); ?></a></nobr>
<br /><br />
<?php if (strlen($username) > 0) { ?>Your username: <?php echo $username; ?><br /><?php } ?>
Your email address: <?php echo $email; ?><br />
Your new password: <?php echo $password; ?><br />
<br />
<br />
</div>
