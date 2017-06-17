<?php
// Register the public and private keys at https://www.google.com/recaptcha/admin
define('PUBLIC_KEY',  '6Lc5UiUUAAAAAOHyx5xE-k6QmgY1pxxfdi1xl-vC');
define('PRIVATE_KEY', '6Lc5UiUUAAAAAMrrt2mDg7myeMWrQzg31b9tCTg5');
// https://developers.google.com/recaptcha/docs/php
require_once('recaptchalib.php');
// Verify the captcha
// https://developers.google.com/recaptcha/docs/verify
$resp = recaptcha_check_answer(PRIVATE_KEY,
                                $_SERVER['REMOTE_ADDR'],
                                $_POST['recaptcha_challenge_field'],
                                $_POST['recaptcha_response_field']
                            );
echo json_encode(array(
    'valid'   => $resp->is_valid,
    'message' => $resp->is_valid ? null : 'Hey, the captcha is wrong!',       // $resp->error,
));
