<?php
    class Captcha{
    public static function createCaptcha(){
		$code=rand(1000,99999);
		$_SESSION["code"]=$code;
		$im = imagecreatetruecolor(53, 24);
		$bg = imagecolorallocate($im, 45, 50, 150);
		$fg = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $bg);
		imagestring($im, 5, 5, 5,  $code, $fg);
		imagepng($im , 'image.png');
	    ob_start();
	        $image = imagecreatefrompng('image.png');
	        imagepng($image);
	        $contents = ob_get_contents();
	    ob_end_clean();
	    $dataUri = "data:image/png;base64," . base64_encode($contents);
    return $dataUri;
	}}
?>

