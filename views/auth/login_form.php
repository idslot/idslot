<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->load->helper('language');
$this->load->library('session');
$msgs = $this->session->userdata('msgs');
$this->session->unset_userdata('msgs');
$data = $this->form_validation->_field_data;
?>
<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'class' => 'ltr login-inp'
);
if ($login_by_username AND $login_by_email) {
  $login_label = lang('Username');
} else if ($login_by_username) {
  $login_label = lang('Username');
} else {
  $login_label = lang('Email');
}
$password = array(
    'name' => 'password',
    'id' => 'password',
    'value' => set_value('password'),
    'class' => 'ltr login-inp'
);
$remember = array(
    'name' => 'remember',
    'id' => 'login-check',
    'value' => 1,
    'checked' => set_value('remember'),
    'class' => 'checkbox-size',
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'class' => 'login-inp'
);

$username = array(
    'name' => 'username',
    'id' => 'username',
    'value' => set_value('username'),
    'class' => 'login-inp',
    'size' => 30,
);

$email = array(
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'size' => 30,
    'class' => 'login-inp'
);
$confirm_password = array(
    'name' => 'confirm_password',
    'id' => 'confirm_password',
    'value' => set_value('confirm_password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
    'class' => 'login-inp'
);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo lang('Idslot') . ' - ' . lang('Login'); ?></title>
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

    <!-- Custom jquery scripts -->
    <script type="text/javascript">
      login_title = '<?php echo lang('Idslot') . ' - ' . lang('Login'); ?>';
      forgot_title = '<?php echo lang('Idslot') . ' - ' . lang('Forgot Password'); ?>';
    </script>
    <script src="<?php echo $base_url; ?>views/js/jquery/custom_jquery.js" type="text/javascript"></script>

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
              <h2 class="logo rightpad"><a href=""></a></h2>
            </div>
          </div>
          <!-- END HEADER -->

        </div>
      </div>
      <div class="container1">





        <!-- START CONTENT -->
        <div class="span-17"><div class="rightpad mainbox">

            <div id="errors">
              <?php
              if ($msgs) {
                foreach ($msgs as $msg) {
                  ?><!--  start message-green -->
                  <div class="notice"><?php echo $msg; ?></div>

                  <?php
                }
              }
//echo validation_errors();
              if (isset($errors)) {
                foreach ($errors as $e) {
                  echo '<div class="error">' . $e . '</div>';
                }
              }
              ?>
            </div>

            <!--  start loginbox ................................................................................. -->
            <div id="loginbox">
              <form method="post" action="login#login">
                <h3 class="title"><?php echo lang('Login'); ?></h3><hr>
                <div class="form">
                  <?php echo form_label($login_label . ':', $login['id']); ?><?php echo form_input($login); ?>
                </div>

                <div class="form">
                  <?php echo form_label(lang('Password') . ':', $password['id']); ?><?php echo form_password($password); ?>
                </div>
                <?php
                if ($show_captcha) {
                  if ($use_recaptcha) {
                    ?>
                    <div class="form">
                      <label><?php echo lang('Confirmation Code'); ?></label><div id="recaptcha_image"></div>
                    </div>
                    <div class="form">
                      <label></label><a href="javascript:Recaptcha.reload()"><?php echo lang('Get another CAPTCHA'); ?></a>

                    </div>
                    <div class="submit">
                      <label></label><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

                      <?php echo $recaptcha_html; ?>
                    </div>
                  <?php } else { ?>
                    <div class="form">
                      <?php echo form_label(lang('Confirmation Code') . ':', $captcha['id']); ?><?php echo form_input($captcha); ?>
                    </div>
                    <div class="form">
                      <label><?php echo lang('Enter the code exactly as it appears:'); ?></label><?php echo $captcha_html; ?>
                    </div>
                    <?php
                  }
                }
                ?>

                <div class="form">
                  <?php echo form_label(lang('Remember me') . ':', $remember['id']); ?><?php echo form_checkbox($remember); ?>
                </div>

                <div class="submit"><label></label><input type="submit" name="submit_login" value="<?php echo lang('Let me in'); ?>" class="form-submit" /></div>
              </form>


              <div class="clear"></div><br>
              <a href="" class="forgot-pwd"><?php echo lang('Forgot Password?'); ?></a>
            </div>
            <!--  end loginbox -->

            <!--  start forgotbox ................................................................................... -->
            <div id="forgotbox">
              <form method="post" action="login#forgot">

                <h3 class="title"><?php echo lang('Login'); ?></h3><hr>

                <h4 class="subtitle"><?php echo lang('Please send us your email and we\'ll reset your password.'); ?></h4>

                <div class="form">
                  <?php echo form_label(lang('Email') . ":", $login['id']); ?><input type="text" name="login" value="" class="ltr login-inp" />
                </div>

                <div class="submit">
                  <label></label><input type="submit" name="submit_forgot" class="form-submit" value="<?php echo lang('Get a new password'); ?>" /></div>


                <!--  end forgot-inner -->
                <div class="clear"></div>
                <a href="" class="back-login"><?php echo lang('Back to login'); ?></a>
              </form>
            </div>
            <!--  end forgotbox -->


          </div></div>
        <div class="span-7 last">
          <div class="span-7 last"><div class="leftpad">
              <div class="block">
                <div class="block-title"><?php echo lang('Idslot'); ?></div>
                <div class="block-content"><?php echo lang('Idslot Description'); ?></div>
              </div>
            </div></div>


        </div>
        <!-- END CONTENT -->
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

    </div>


  </body>
</html>
