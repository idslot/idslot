<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
$this->load->helper('language');
$data = $this->form_validation->_field_data;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo lang('Idslot') . ' - ' . lang($page_title); ?></title>
    <link rel="shortcut icon" href="<?php echo $base_url; ?>application/views/images/favicon.png" type="image/png" />
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
      });
    </script>

    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/custom_jquery.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>application/views/js/jquery/jquery.qtip-1.0.0-rc3.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.datepicker0').datepicker({
          dateFormat: '<?php echo lang('Date Format'); ?>',
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
    <script>
      $(document).ready(
      function() {
        $("#photos").sortable({
          placeholder: "ui-state-highlight",
          update : function () {
            serial = $('#photos').sortable('serialize');
            $.ajax({
              url: "<?php echo site_url('plugins/idslot_photos/sort/') . ""; ?>",
              type: "post",
              data: serial,
              error: function(){
                alert("<?php echo lang('Error in connection'); ?>");
              }
            });
          }
        });
        $("#links").sortable({
          placeholder: "ui-state-highlight",
          update : function () {
            serial = $('#links').sortable('serialize');
            $.ajax({
              url: "<?php echo site_url('plugins/idslot_links/sort/') . ""; ?>",
              type: "post",
              data: serial,
              error: function(){
                alert("<?php echo lang('Error in connection'); ?>");
              }
            });
          }
        });
      }
    );
    </script>
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
      <div class="container0">
        <div class="header">
          <!-- START HEADER -->
          <div class="span-24 htop">
            <div class="span-12">
              <div class="beta"></div>
              <h2 class="logo rightpad"><a href=""></a></h2>
            </div>
            <div class="span-12 last">
              <div class="reverse-float leftpad toplinks" style="margin-top: 7px;"><a<?php echo ($page_title == 'Settings') ? ' id="current"' : ''; ?> href="<?php echo site_url('idslot/settings'); ?>"><?php echo lang('Settings'); ?></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('auth/logout'); ?>" id="logout"><?php echo lang('Logout'); ?></a></div>
            </div>
          </div>
          <!-- END HEADER -->

          <!-- START NAV MENU -->
          <div class="span-24">
            <div class="span-24">
              <ul id="navlist">
                <?php
                foreach ($plugins as $pname => $ptitle) {
                  ?>
                  <li><a<?php echo ($page_title == $ptitle) ? ' id="current"' : ''; ?> href="<?php echo site_url("idslot/edit/" . $pname); ?>"><?php echo lang($ptitle); ?></a></li>
                  <?php
                }
                ?>
                <li><a<?php echo ($page_title == 'Resume') ? ' id="current"' : ''; ?> href="<?php echo site_url('idslot/resume'); ?>"><?php echo lang('Resume'); ?></a></li>
                <li><a<?php echo ($page_title == 'Details') ? ' id="current"' : ''; ?> href="<?php echo site_url('idslot/details'); ?>"><?php echo lang('Details'); ?></a></li>
                <li><a href="<?php echo $base_url; ?>" target="_blank"><?php echo lang('View Card'); ?></a></li>
              </ul>
            </div>
          </div>
          <!-- END NAV MENU -->
        </div>
      </div>
      <div class="container1">


        <!-- START CONTENT -->
        <div class="span-17"><div class="rightpad mainbox">
            <div id="page-heading"><h3 class="title"><?php
                if (in_array($page_title, $plugins)) {
                  echo lang('Edit') . ' ' . lang($page_title);
                } else {
                  echo lang($page_title);
                }
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
            $other_plugins = array('Details', 'Settings', 'Feedback', 'Resume', 'Inviter', 'Services');
            if (in_array($page_title, $plugins) || in_array($page_title, $other_plugins)) {
              $this->load->view('user/plugins/' . strtolower($page_title) . '_edit.tpl', $plugin);
            } else {
              $this->load->view('user/' . strtolower($page_title) . '.tpl');
            }
            ?>
            <!-- end id-form  -->
          </div></div>
        <div class="span-7 last">
          <div class="span-7 last"><div class="leftpad">
              <div class="block">
                <div class="block-title"><?php echo lang($page_title); ?></div>
                <div class="block-content"><?php echo lang($page_title . ' Description'); ?></div>
              </div>
            </div></div>

          <div class="span-7 last"><div class="leftpad">
              <div class="block">
                <div class="block-title"><?php echo lang('Update idslot'); ?></div>
                <div class="block-content"><?php echo lang('How to update idslot'); ?></div>
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
            <a href="http://idslot.org/" target="_blank"><img src="<?php echo $base_url; ?>/application/views/images/footer.png" alt="<?php echo lang('Idslot'); ?>" /></a>
          </div>
        </div> 
        <!-- END FOOTER -->
      </div>
    </div>

  </body>
</html>
