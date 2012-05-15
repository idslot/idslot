<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->lang->load('install');
$this->load->helper('language');
$data = $this->form_validation->_field_data;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo lang('Idslot'); ?></title>

    <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/screen.css" type="text/css" media="screen, projection" />
    <link type="text/css" href="<?php echo $base_url; ?>application/views/css/jquery-ui.css" rel="Stylesheet" />	
    <!--[if lt IE 8]>
      <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/ie.css" type="text/css" media="screen, projection" />
    <![endif]-->

    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <!--  styled file upload script --> 
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery.filestyle.js" type="text/javascript"></script>

    <!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
    <script src="<?php echo $base_url; ?>application/views/js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).pngFix( );
        $('#refresh').click(function() {
          location.reload();
        });
      });


    </script>

    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/custom_jquery.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/jquery.qtip-1.0.0-rc3.min.js"></script>

    <?php
    if (lang('direction') == 'rtl') {
      ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/qtip-rtl.js"></script>
      <link rel="stylesheet" href="<?php echo $base_url; ?>application/views/css/rtl.css" type="text/css" media="screen" title="default" />
      <?php
    } else {
      ?>
      <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/qtip-ltr.js"></script>
      <?php
    }
    ?>
    <script>
      required = "<?php echo lang('Required'); ?>";
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


        <!-- START CONTENT -->
        <div class="span-17"><div class="rightpad mainbox">
            <div id="page-heading"><h3 class="title"><?php
    echo lang($current_step);
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
$this->load->view('user/install/' . strtolower($current_step) . '.tpl');
?>
            <!-- end id-form  -->
          </div></div>
        <div class="span-7 last">

          <div class="span-7 last"><div class="leftpad">
              <div class="block">
                <div class="block-title"><?php echo lang('Install idslot'); ?></div>
                <div class="block-content"><?php echo lang('How to install idslot'); ?></div>
              </div>
            </div></div>

          <div class="span-7 last"><div class="leftpad">
              <div class="block">
                <div class="block-title"><?php echo lang('Install steps'); ?></div>
                <div class="block-content">
                  <ul>
                    <?php
                    foreach ($steps as $step) {
                      ?>
                      <li><a<?php echo ($current_step == $step) ? ' style="font-weight: bold;"' : ''; ?>><?php echo lang($step); ?></a></li>
                      <?php
                    }
                    ?>
                  </ul>
                </div></div>
            </div></div>


        </div>
        <!-- END CONTENT -->
      </div>
      <!-- START FOOTER -->
      <div class="span-24 footer quiet">

        <div class="footer1">
<?php echo lang('Copyright') . " " . date('Y'); ?>
        </div>

        <div class="footer2">
        </div>
      </div> 
      <!-- END FOOTER -->

    </div>

  </body>
</html>
