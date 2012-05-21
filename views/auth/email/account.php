<?php
// You must call validation to get the users posted information
$val = $this->validation;
?>
Welcome to <?php echo $this->config->item('CL_website_name');?>,

Thank you for registering. Your account was successfully created.

You can login with either your username or email address:

Login: <?php echo $val->username."\n";?>
Email: <?php echo $val->email."\n";?>
Password: <?php echo $val->password."\n";?>

You can try logging in now by going to <?php echo site_url($this->config->item('CL_login_uri')); ?>.

We hope that you enjoy your stay with us :)

Regards,
The <?php echo $this->config->item('CL_website_name');?> Team