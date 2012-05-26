<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->load->helper('language');
?>
<?php
$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo lang('Idslot'); ?></title>
    <link rel="shortcut icon" href="<?php echo $base_url; ?>views/images/favicon.png" type="image/png" />
    <link rel="stylesheet" href="<?php echo $base_url; ?>views/css/screen.css" type="text/css" media="screen, projection" />
    <link type="text/css" href="<?php echo $base_url; ?>views/css/jquery-ui.css" rel="Stylesheet" />	
    <!--[if lt IE 8]>
      <link rel="stylesheet" href="<?php echo $base_url; ?>views/css/ie.css" type="text/css" media="screen, projection" />
    <![endif]-->


    <?php
    if (lang('direction') == 'rtl') {
      ?>
      <link rel="stylesheet" href="<?php echo $base_url; ?>views/css/rtl.css" type="text/css" media="screen" title="default" />
      <?php
    }
    ?>

    <script src="<?php echo $base_url; ?>views/js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <!--  styled file upload script -->
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery.filestyle.js" type="text/javascript"></script>


    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).pngFix( );
        check_auth_hash();
      });
    </script>

  </head>

  <body>
    <div class="container prepend-top">
      <div class="container0">
        <div class="header">
          <!-- START HEADER -->
          <div class="span-24 htop">
            <div class="span-12">
              <div class="beta"></div>
              <h2 class="logo rightpad"><a href="<?php echo $base_url; ?>"></a></h2>
            </div>
          </div>
          <!-- END HEADER -->

        </div>
      </div>
      <div class="container1">



        <!-- START CONTENT -->
        <div class="span-17"><div class="rightpad">

            <div id="errors">
              <?php
              //echo validation_errors();
              if (isset($errors)) {
                foreach ($errors as $e) {
                  echo '<div class="error">' . $e . '</div>';
                }
              }
              ?>
            </div>
            <?php echo form_open($this->uri->uri_string()); ?>
            <fieldset>
              <div class="form">
                <?php echo form_label(lang('New Password'), $new_password['id']); ?>:
                <?php echo form_password($new_password); ?>
                <div class="desc"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']]) ? $errors[$new_password['name']] : ''; ?></div>
              </div>
              <div class="form">
                <?php echo form_label(lang('New Password Confirm'), $confirm_new_password['id']); ?>:
                <?php echo form_password($confirm_new_password); ?>
                <div class="desc"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']]) ? $errors[$confirm_new_password['name']] : ''; ?></div>
              </div>
              <div class="submit">
                <label>&nbsp;</label>
                <?php echo form_submit('change', lang('Change Password')); ?>
              </div>
            </fieldset>
            <?php echo form_close(); ?>

          </div></div>
        <div class="span-7 last"><div class="leftpad">
            <div class="block">
              <div class="block-title"><?php echo lang('Idslot'); ?></div>
              <div class="block-content"><?php echo lang('Idslot Description'); ?></div>
            </div>
          </div></div>
        <div class="span-24 append-bottom"></div>
      </div>
      <div class="container2">
        <!-- START FOOTER -->
        <div class="footer quiet">

          <div class="footer1">
            <?php echo lang('Idslot'); ?>
          </div>

          <div class="footer2">
            <a href="http://idslot.org/" target="_blank"><img src="<?php echo $base_url; ?>/views/images/footer.png" alt="<?php echo lang('Idslot'); ?>" /></a>
          </div>
        </div> 
        <!-- END FOOTER -->
      </div>

  </body>
</html>