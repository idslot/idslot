<?php
$this->load->model('system');
$lang = $this->system->languages();
$this->load->helper('url');
$this->lang->load('idslot');
$base_url = base_url();
$this->load->helper('language');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="<?php echo $user->meta_keywords; ?>" />
    <meta name="title" content="<?php echo $user->title; ?>" />
    <meta name="description" content="<?php echo $user->meta_description; ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $user->title; ?></title>
    
    <!--styles-->
    <link href="views/idslot/theme/styles/style.css" type="text/css" rel="stylesheet" />
    
    <link href="views/idslot/theme/styles/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
    <!--javascript-->
    <script type="text/javascript" src="views/idslot/theme/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="views/idslot/theme/js/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="views/idslot/theme/js/jquery.infieldlabel.min.js"></script>
    <script type="text/javascript" src="views/idslot/theme/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript">
      var title = "<?php echo $user->title; ?>";
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
			
        $("label").inFieldLabels();
		
        $("a.map").fancybox({
          'transitionIn'	:	'fade',
          'transitionOut'	:	'fade',
          'speedIn'		:	600, 
          'speedOut'		:	200, 
          'overlayShow'	:	false,
          'overlayShow' : true,
          'titlePosition' : 'inside',
          'padding': 5
        });
		
        $("a.photos").fancybox({
          'transitionIn'	:	'elastic',
          'transitionOut'	:	'elastic',
          'speedIn'		:	600, 
          'speedOut'		:	200, 
          'overlayShow'	:	false,
          'overlayShow' : true,
          'titlePosition' : 'inside',
          'padding': 5
        });
        $("a.photo").fancybox({
          'transitionIn'	:	'elastic',
          'transitionOut'	:	'elastic',
          'speedIn'		:	600, 
          'speedOut'		:	200, 
          'overlayShow'	:	false,
          'overlayShow' : true,
          'titlePosition' : 'inside',
          'padding': 5
        });
        $('.item').click(function() {
          $('.item').removeClass("active");
          $(this).addClass("active");
        }); 
		
      });
    </script>

  </head>
  <body>

    <div class="cornerBox">

      <div class="cornerBoxInner">

        <div class="maincontent idslot">
          <div class="header">
            <span class="htitle"><?php echo $user->title; ?></span>
            <span class="desc"><?php echo $user->short_description; ?></span>
          </div>

          <div class="navigation">
            <?php
            foreach ($plugins as $pname => $plugin) {
              if ($pname == 'about') {
                ?>
                <span class="item active"><a href="<?php echo "#" . $pname ?>"><?php echo trim($plugin['title']) ? $plugin['title'] : lang(ucfirst($pname)); ?></a></span>
                <?php
              } else {
                ?>
                <span class="item"><a href="<?php echo "#" . $pname ?>"><?php echo trim($plugin['title']) ? $plugin['title'] : lang(ucfirst($pname)); ?></a></span>
                <?php
              }
            }
            if ($has_resume) {
              if(file_exists("views/idslot/files/resume/$uid.pdf")){
                $rtype = '.pdf';
              }else{
                $rtype = '.html';
              }
              ?>
              <span class="item"><a href="views/idslot/files/resume/<?php echo $uid . $rtype; ?>" target="blank"><?php echo lang('Resume'); ?></a></span>
              <?php
            }
            ?>
          </div>

          <div id="datacontent" class="panels">
            <?php
            foreach ($plugins as $plugin) {
              print($plugin['view']);
            }
            ?>
          </div>

        </div>

      </div>
    </div>
    <div class="footer">Powered by <a href="http://idslot.org" title="<?php echo lang('Idslot'); ?>"><img src="views/images/footer.png" alt="<?php echo lang('Idslot'); ?>" /></a></div>

    <script src="views/idslot/theme/js/init.js" type="text/javascript"></script>
  </body>
</html>
