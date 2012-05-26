<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->load->helper('language');
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

    <script src="<?php echo $base_url; ?>views/js/jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <!--  styled file upload script --> 
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery.filestyle.js" type="text/javascript"></script>

    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url; ?>views/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).pngFix( );
        $('#refresh').click(function() {
          location.reload();
        });
      });


    </script>

    <script type="text/javascript" src="<?php echo $base_url; ?>views/js/jquery/custom_jquery.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>views/js/jquery/jquery.qtip-1.0.0-rc3.min.js"></script>

    <?php
    if (lang('direction') == 'rtl') {
      ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>views/js/qtip-rtl.js"></script>
      <link rel="stylesheet" href="<?php echo $base_url; ?>views/css/rtl.css" type="text/css" media="screen" title="default" />
      <?php
    } else {
      ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>views/js/qtip-ltr.js"></script>
      <?php
    }
    ?>
    <script>
      required = "<?php echo lang('Required'); ?>";
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
            <div class="span-12 last">

            </div>
          </div>
          <!-- END HEADER -->

          <!-- START NAV MENU -->
          <div class="span-24">
            <div class="span-24">

            </div>
          </div>
          <!-- END NAV MENU -->
        </div>
      </div>
      <div class="container1">

        <!-- START CONTENT -->
        <div class="span-17"><div class="rightpad mainbox">
            <div id="page-heading"><h3 class="title"><?php
    echo lang('Upgrade');
    ?></h3><hr></div>


            <?php
            /// @TODO use system model!
            //$this->load->model('system');
            $this->load->library('session');
            $msgs = $this->session->userdata('msgs');
            $this->session->unset_userdata('msgs');
            if ($msgs) {
              foreach ($msgs as $msg) {
                ?><!--  start message-green -->
                <div class="notice"><?php echo $msg; ?></div>

                <?php
              }
            }
            ?>
            <?php
            if (isset($errors) && $errors) {
              foreach ($errors as $e) {
                if (trim($e) == '')
                  continue;
                ?>
                <div class="error"><?php echo $e; ?></div>
                <?php
              }
            }
            ?>


            <!-- start id-form -->
            <?php
            $upgrade_button = '';
            $upgrade_desc = lang('Latest version');
            echo lang('Current version') . ": $current_version<br />";
            if ($local_version) {
              echo lang('Local version') . ": $local_version<br />";
            } elseif ($remote_version) {
              echo lang('Remote version') . ": $remote_version<br />";
            }
            if (!$config) {
              if($local_version || $remote_version){
                $upgrade_desc = "config/config.php " . lang('must be writable for upgrade');
              }
            } else {
              if ($local_version) {
                $upgrade_button = '<a class="button form-submit" href="' . site_url('upgrade/local') . '">' . lang('Complete upgrade') . '</a>';
                $upgrade_desc = lang('Complete local upgrade');
              } elseif ($remote_version && $auto_upgrade) {
                $upgrade_button = '<a class="button form-submit" href="' . site_url('upgrade/remote') . '">' . lang('Upgrade Automatically') . '</a>';
                $upgrade_desc = lang('Automatic upgrade');
              } elseif ($remote_version) {
                $upgrade_desc = lang('Manual upgrade');
              }
            }
            echo "<br />$upgrade_desc<br />";
            ?>
            <br /><br />
            <div class="form">
              <label>&nbsp;</label><?php echo $upgrade_button; ?> <a class="button form-submit" href="<?php echo site_url('idslot') ?>" ><?php echo __("Go back to IDSlot"); ?></a>
            </div>
            <!-- end id-form  -->
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
