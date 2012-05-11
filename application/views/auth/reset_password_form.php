<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->load->helper('language');
?>
<?php
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo lang('Idslot') . ' - ' . lang('Register'); ?></title>

    <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/screen.css" type="text/css" media="screen, projection" />
    <link type="text/css" href="<?php echo $base_url; ?>application/views/css/jquery-ui.css" rel="Stylesheet" />	
    <!--[if lt IE 8]>
      <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/ie.css" type="text/css" media="screen, projection" />
    <![endif]-->


<?php
if (lang('direction') == 'rtl') {
?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/rtl.css" type="text/css" media="screen" title="default" />
<?php
  }
?>

    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <!--  styled file upload script -->
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery.filestyle.js" type="text/javascript"></script>

    <!-- Custom jquery scripts -->
    <script type="text/javascript">
      register_title = '<?php echo lang('Register'); ?>';
    </script>

    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      $(document).pngFix( );
      check_auth_hash();
      });
    </script>

    <link type="text/css" href="<?php echo $base_url; ?>application/views/css/ui.datepicker.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/jquery.ui.datepicker-cc.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/calendar.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/jquery.ui.datepicker-cc-ar.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/jquery.ui.datepicker-cc-fa.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
	    $('.datepicker0').datepicker({
		    dateFormat: 'yy-mm-dd',
		    changeMonth: true,
		    changeYear: true,
	            regional: '<?php echo lang('lang'); ?>'
	        });
		$( ".skill" ).autocomplete({
			source: "<?php echo site_url('plugins/idslot_resume/suggest_skill/'); ?>",
			minLength: 2
		});
	});
    </script>
  </head>

  <body>
    <div class="container prepend-top">
		<div class="container1 span-24">


    <div class="header">
	    <!-- START HEADER -->
      <div class="span-24 htop">
        <div class="span-12">
					<div class="beta"></div>
          <h2 class="logo rightpad"><a href="<?php echo $base_url; ?>"></a></h2>
        </div>
      </div>
	    <!-- END HEADER -->

      <!-- START NAV MENU -->
      <div class="span-24">
        <div class="span-24">
						<ul id="navlist">
              <li><a href="<?php echo site_url('/pages') ?>"><?php echo lang('Home'); ?></a></li>
              <li><a href="<?php echo site_url('/pages/idslot') ?>"><?php echo lang('What is idslot'); ?></a></li>
              <li><a href="<?php echo site_url('/auth/register') ?>"><?php echo lang('Register'); ?></a></li>
						</ul>
        </div>
      </div>
      <!-- END NAV MENU -->
    </div>


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
		<div class="desc"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></div>
  </div>
	<div class="form">
		<?php echo form_label(lang('New Password Confirm'), $confirm_new_password['id']); ?>:
		<?php echo form_password($confirm_new_password); ?>
		<div class="desc"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></div>
  </div>
  <div class="submit">
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
      <!-- START FOOTER -->
      <div class="span-24 footer quiet"> 
        <ul class="nav-footer">
        </ul>
				<div class="footerlogos">
					<h2 class="www"><a href="http://www.idslot.org" target="_blank"></a></h2>
					<h2 class="saman"><a href="http://www.sb24.com" target="_blank"></a></h2>
				</div>
        <ul class="nav-legal">
          <li><?php echo lang('Copyright text') ." ". date('Y'); ?></li>
          <li><a href="<?php echo site_url('/pages/about') ?>"><?php echo lang('About'); ?></a></li>
          <li><a href="<?php echo site_url('/pages/support') ?>"><?php echo lang('Support'); ?></a></li>
          <li><a href="<?php echo site_url('/pages/employment') ?>"><?php echo lang('Employment'); ?></a></li>
          <li><a href="<?php echo site_url('/pages/tos') ?>"><?php echo lang('Terms of use'); ?></a></li>
          <li class="last"><a href="<?php echo site_url('/pages/privacy') ?>"><?php echo lang('Privacy'); ?></a></li>
        </ul>
      </div> 
      <!-- END FOOTER -->

<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://idslot.org/piwik/" : "http://idslot.org/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://idslot.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

</body>
</html>