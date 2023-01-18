<?php
class Captcha
{
    public function generateCaptcha($length,$type='both'){
        if ($type == "character"){
            $array = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','w','x','y','z'];
        }elseif ($type == "number"){
            $array = ['0','1','2','3','4','5','6','7','8','9'];
        }else {
            $array =['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','w','x','y','z','0','1','2','3','4','5','6','7','8','9'];
        }
        $captcha_string = "";
        for ($i = 0; $i < $length; $i++){
            $captcha_string .= $array[rand(0,count($array)-1)];
        }
 	    $this->createCaptchaImage($captcha_string);
    }


    function createCaptchaImage($permitted_chars){

        $image = imagecreatetruecolor(200,50);
        imageantialias($image,true);
        $colors=[];
        $red = rand(0,100);
        $green = rand(0,100);
        $blue = rand(0,100);
        
        for ($i = 0;$i< 7;$i++) {
            $colors[]=imagecolorallocate($image,$red,$green,$blue);
//            $colors[]=imagecolorallocate($image,$red-20*$i,$green-20*$i,$blue-20*$i);
        }
//        $bg = imagecolorallocate($image, 200, 200, 200);

//        $white = imagecolorallocate($image, 255, 255, 255);
//         imagecolorallocate($image, 0, 0, 0);

        imagefill($image,0,0,$colors[0]);
        for ($i = 0;$i< 60;$i++) {
            imagesetthickness($image,rand(2,3));
            $line_color = $colors[rand(1,4)];
        //    imagerectangle($image,rand(-10,190),rand(-10,10),rand(-10,190),rand(40,60),$line_color);
            imagearc(
                $image,
                rand(1, 900), // x-coordinate of the center.
                rand(1, 900), // y-coordinate of the center.
                rand(1, 900), // The arc width.
                rand(1, 900), // The arc height.
                rand(1, 900), // The arc start angle, in degrees.
                rand(1, 900), // The arc end angle, in degrees.
                (rand(0, 10)) // A color identifier.
            );
        }
        
        //
        $black = imagecolorallocate($image,0,0,0);
        $white = imagecolorallocate($image,255,255,255);
        $red = rand(101,255);
        $green = rand(101,255);
        $blue = rand(101,255);
        $text_colors = imagecolorallocate($image, $red, $blue,$green ); // set captcha text color

        $fonts =[dirname(__FILE__).'\fonts\Acme.ttf',dirname(__FILE__).'\fonts\Ubuntu.ttf', dirname(__FILE__).'\fonts\Merriweather.ttf', dirname(__FILE__).'\fonts\PlayfairDisplay.ttf',dirname(__FILE__).'\fonts\Captcha.otf'];
        $string_length = strlen($permitted_chars);
        $captcha_string = $permitted_chars;
        $_SESSION['captcha_text'] = $captcha_string;
        for ($i =0;$i<$string_length;$i++){
            $letter_space = 170/$string_length;
            $initial =15;
            imagettftext($image,24,rand(-15,15),$initial+$i*$letter_space,rand(25,45),$text_colors,$fonts[array_rand($fonts)],$captcha_string[$i]);
        }
        header('Content-type:image/png');
        imagepng($image);
        imagedestroy($image);
    }

}


