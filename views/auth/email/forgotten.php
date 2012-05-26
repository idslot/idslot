<?=$this->config->item('CL_website_name');?>,

You have requested for your password to be reset. Please follow this link in order to complete the reset process:
<?=$reset_uri?>

If the link doesn't work, then please use the form provided here:
<?=site_url('auth/reset')?>

Your New Password: <?=$password;?>
Key for Activation: <?=$key;?>
