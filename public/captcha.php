<?php
    class Captcha{
        public static function createCaptcha(){
	$code=rand(1000,9999);
	$_SESSION["code"]=$code;
	$im = imagecreatetruecolor(50, 24);
	$bg = imagecolorallocate($im, 22, 86, 165);
	$fg = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $bg);
	imagestring($im, 5, 5, 5,  $code, $fg);
	imagepng($im , 'image.png');

    ob_start();
        $image = imagecreatefrompng('image.png');
        imagefilter($image, IMG_FILTER_PIXELATE, 1, true);
        imagefilter($image, IMG_FILTER_MEAN_REMOVAL);
        imagepng($image);
        $contents = ob_get_contents();
    ob_end_clean();
    $dataUri = "data:image/png;base64," . base64_encode($contents);
    return $dataUri;
}}
?>