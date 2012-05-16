<?php
/**
 * IDSlot
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package	IDSlot
 * @author	IDSlot Development Team
 * @copyright	Copyright (c) 2012, IDSlot Development Team
 * @license	http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link	http://idslot.org
 */

class Captcha extends CI_Controller{
  public function __construct() {
    parent::__construct();
    $this->load->library('session');
  }
  
  public function generate($idslot=false){
    $str = "";
    $length = 0;
    for ($i = 0; $i < 3; $i++) {
      // these numbers represent ASCII table (small letters)
      $str .= chr(rand(97, 122));
    }

//determine width and height for our image and create it
    if($idslot){
      $imgW = 45;
      $imgH = 22;      
    }else{
      $imgW = 300;
      $imgH = 100;
    }    
    $data['captcha_code'] = $str;
    $this->session->set_userdata($data);

    $image = imagecreatetruecolor($imgW, $imgH);

//setup background color and border color
    $backgr_col = imagecolorallocate($image, 255, 255, 255);
    $border_col = imagecolorallocate($image, 255, 255, 255);

//let's choose color in range of gray
    $color = rand(50, 150);
    $text_col = imagecolorallocate($image, $color, $color, $color);

//now fill rectangle and draw border
    imagefilledrectangle($image, 0, 0, $imgW, $imgH, $backgr_col);
    imagerectangle($image, 0, 0, $imgW - 1, $imgH - 1, $border_col);

//save fonts in same folder where you PHP captcha script is
//name these fonts by numbers from 1 to 3
//we shall choose different font each time
    $fn = rand(1, 3);
    $font = './captcha/fonts/' . $fn . ".ttf";

//setup captcha letter size and angle of captcha letters
    $font_size = $imgH / 2;
    $angle = rand(-15, 15);
    $box = imagettfbbox($font_size, $angle, $font, $str);
    $x = (int) ($imgW - $box[4]) / 2;
    $y = (int) ($imgH - $box[5]) / 2;
    imagettftext($image, $font_size, $angle, $x, $y, $text_col, $font, $str);

//now we should output captcha image
    header("Content-type: image/png");
    imagepng($image);
    imagedestroy($image);
  }
}
