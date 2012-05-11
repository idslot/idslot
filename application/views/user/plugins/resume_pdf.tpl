<?php
$this->load->helper('url');
$base_url = base_url();
?>
<html>
    <head>
        <title><?php echo lang('Resume') . ' ' . $details['title']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo $details['meta_keywords']; ?>" />
        <meta name="title" content="<?php echo $details['title']; ?>" />
        <meta name="description" content="<?php echo $details['meta_keywords']; ?>" />

        <style>
            body {margin:0;color:#333333;font-family:verdana,helvetica,arial,sans-serif; font-size: 15px; line-height: 25px;}
            .mainDiv {background:#fff; width:1035px; margin:auto; padding-bottom:40px;}
            .header {background:#eeeeee; border-bottom: 1px solid #bbb; padding: 50px 40px 25px 40px;font-size: 25px; color:#475261; font-family:Nunito,Nunito1;}
            .header div{display: inline-block; vertical-align: middle;}
            .name {padding-left:15px;}
            .name img{padding: 10px; margin-right: 10px; background:#fff; border: 1px solid #aaa; float:left;}
            .description {font-size:20px;}
            .contacts{float:right; font-size: 15px;}
            .contacts span{display:block;}
            .section {margin: 0 40px 0 40px; border-bottom: 1px solid #bbb; padding: 30px 0 30px 0;}
            .last {border: 0;}
            .section h1{display:inline-block;position:static; width: 180px; font-size: 20px; color:#475261; font-family:Nunito,Nunito1; font-weight:normal; vertical-align:top; margin:0;}
            .subsection {display:inline-block;position:static}
            li {padding:0; margin:0 0 10px 0; list-style-type: circle;}
            ul {padding:0; margin:0;}
            .wrap{display:block;}
            .reverseFloat{float:right; padding: 0 0 0 10px;}
@font-face {
  font-family: 'Nunito1';
  font-style: normal;
  font-weight: 700;
  src: local('Nunito Bold'), local('Nunito-Bold'), url('http://themes.googleusercontent.com/font?kit=TttUCfJ272GBgSKaOaD7Kj8E0i7KZn-EPnyo3HZu7kw') format('woff');
}
@font-face {
  font-family: 'Nunito1';
  font-style: normal;
  font-weight: 400;
  src: local('Nunito'), url('http://themes.googleusercontent.com/font?kit=0rdItLTcOd8TSMl72RUU5w') format('woff');
}

        </style>

        
<?php
if(lang('direction') == 'rtl'){
?>
        <style>
            body {font-family:BYekan,verdana,helvetica,arial,sans-serif; font-size: 18px; direction:rtl;}
            .header {font-size: 30px;font-family:BYekan;}
            .name {padding-right:15px; padding-left:0;}
            .name img{margin-left: 10px; margin-right:0; float:right;}
            .description {font-size:25px;}
            .contacts{float:left; font-size: 20px;}
            .section h1{font-size: 20px;font-family:BYekan;}
            .reverseFloat{float:left; padding: 0 10px 0 0;}
        </style>
<?php
}
?>
        
    </head>
    <body>
    <div class="mainDiv">
        <div class="header">
            <div class="name"><img src="../about/thumb_<?php echo $user->id;?>.png" /><?php echo $details['title']; ?><span class="wrap description"><?php echo $details['short_description']; ?></span></div>
            <div class="contacts">
                <?php if(strlen($contact['email'])){ ?>
                <span><?php echo lang('Contact Email'); ?>:<div class="reverseFloat"><?php echo $contact['email']; ?></div></span>
                <?php }if(strlen(str_replace('http://', '', $contact['website']))){ ?>
                <span><?php echo lang('Web Site'); ?>:<div class="reverseFloat"><?php echo $contact['website']; ?></div></span>
                <?php }if(strlen(str_replace('http://', '', $contact['weblog']))){ ?>
                <span><?php echo lang('Weblog'); ?>:<div class="reverseFloat"><?php echo $contact['weblog']; ?></div></span>
                <?php }if(strlen($contact['tel'])){ ?>
                <span><?php echo lang('Telephone'); ?>:<div class="reverseFloat"><?php echo $contact['tel']; ?></div></span>
                <?php }if(strlen($contact['mob'])){ ?>
                <span><?php echo lang('Cellphone'); ?>:<div class="reverseFloat"><?php echo $contact['mob']; ?></div></span>
                <?php } ?>
            </div>
        </div>

        <?php if($resume['summary']){ ?>
        <div class="section">
            <h1><?php echo lang('Summary'); ?></h1>
            <div class="subsection"><?php echo $resume['summary']; ?></div>
        </div>
        <?php } ?>
        
        <?php if($resume['experiences']){ ?>
        <div class="section">
            <h1><?php echo lang('Experiences'); ?></h1>
            <div class="subsection"><ul>
            <?php
            foreach($resume['experiences'] as $experience){
                printf('<li>%s<ol>%s</ol><ol>%s %s %s %s</ol></li>', $experience['summary'], $experience['description'], lang('From'), $experience['start'], lang('To'), $experience['end']);
            }
            ?>
            </ul>
            </div>
        </div>
        <?php } ?>
        
        <?php if($resume['educations']){ ?>
        <div class="section">
            <h1><?php echo lang('Educations'); ?></h1>
            <div class="subsection"><ul>
            <?php
            foreach($resume['educations'] as $education){
                printf('<li>%s<ol>%s</ol><ol>%s %s %s %s</ol></li>', $education['summary'], $education['description'], lang('From'), $education['start'], lang('To'), $education['end']);
            }
            ?>
            </ul>
            </div>
        </div>
        <?php } ?>
        
        <?php if($resume['skills']){ ?>
        <div class="section">
            <h1><?php echo lang('Skills'); ?></h1>
            <div class="subsection"><ul>
            <?php
            foreach($resume['skills'] as $skill){
                printf('<li>%s</li>', $skill['title']);
            }
            ?>
            </ul>
            </div>
        </div>
        <?php } ?>
        
        <?php if($resume['publications']){ ?>
        <div class="section last">
            <h1><?php echo lang('Publications'); ?></h1>
            <div class="subsection"><ul>
            <?php
            foreach($resume['publications'] as $publication){
                printf('<li>%s<ol>%s: %s</ol><ol>%s: %s</ol><ol>%s: %s</ol></li>', $publication['title'], lang('Creators'), $publication['creators'], lang('Publisher'), $publication['publisher'], $publication['urn_type'], $publication['urn']);
            }
            ?>
            </ul>
            </div>
        </div>
        <?php } ?>
        
    </div>
    </body>
</html>