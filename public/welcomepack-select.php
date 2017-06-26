<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();
    function RemoveSimbols($var) {
                $var = htmlentities($var, ENT_NOQUOTES, 'UTF-8');
                $var = preg_replace('/[^\p{L}\p{N}\s]/u', '', $var);
                return $var;
    }
    try
    {
        if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"])
        {
            $encode_captcha = htmlspecialchars($_POST["captcha"], ENT_QUOTES);
            if($encode_captcha !== htmlspecialchars($encode_captcha) || $encode_captcha !== RemoveSimbols($_POST['captcha']))
            {
                header('Location:oops.php', true, 302);
                exit;
            }
        }
        else
        {header('Location:oops.php', true, 302); exit;}

        if(!empty($_POST))
        {
            $encode_country = htmlspecialchars($_POST['country'], ENT_QUOTES);


            if($encode_country !== htmlspecialchars($encode_country) || $encode_country !== RemoveSimbols($_POST['country']))
            {
                header('Location:oops.php', true, 302);
                exit;
            }
            else
            {
                if($encode_country == 'Thailand')
                {
                    header('Location: winprize.php', true, 302);
                exit;
                }
                if(isset($_COOKIE['already'])) {
                    header('Location: already.php', true, 302);
                    exit;
                }
                else
                {

                    $_SESSION['country'] = $encode_country;
                    if (empty($_SESSION['token'])) {
                        if (function_exists('mcrypt_create_iv')) {
                            $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                        } else {
                            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                        }
                    }
                    $token = $_SESSION['token'];

                }
            }
            //header('Location: success.php', true, 302);
            //exit;
        }
        else
        {
            header('Location: oops.php', true, 302);
            exit;
        }
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

?>

<div class="bg-white animated fadeIn" style="min-height: 75vh">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 i6-nopad">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-30-t">Greeting you with <br>Thailand Grand Sale</h1>
                        <p  class="push-20">Choose your welcome offer</p>
                    </div>

                    <!-- Lucky Register Form -->
                    <form class="form-horizontal push-10-t" id="wp_form" action="welcomepack-submit.php" method="POST" autocomplete="off">
                        <div class="form-group text-center margin-0">
                            <div class="col-sm-12 col-md-4">
                                <label class="checkbox-inline wp-form-select">
                                    <input type="checkbox" name="wp_check[]" value="1" />
                                    <div class="img-container text-left">
                                        <img src="<?php echo Settings::full_url(); ?>assets/img/upload/w1.jpg" alt="">
                                        <h5 class="push-10-t">100 THB discount for any<br> Grab services</h5>
                                        <div class="select-box">
                                            <div class="popover-wp"><i class="fa fa-check"></i></div>
                                            <p>Select</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="checkbox-inline wp-form-select">
                                    <input type="checkbox" name="wp_check[]" value="2" />
                                    <div class="img-container text-left">
                                        <img src="<?php echo Settings::full_url(); ?>assets/img/upload/w2.jpg" alt="">
                                        <h5 class="push-10-t">Free Tourist SIM Card</h5>
                                        <div class="select-box">
                                            <div class="popover-wp"><i class="fa fa-check"></i></div>
                                            <p>Select</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="checkbox-inline wp-form-select">
                                    <input type="checkbox" name="wp_check[]" value="3" />
                                    <div class="img-container text-left">
                                        <img src="<?php echo Settings::full_url(); ?>assets/img/upload/w3.jpg" alt="">
                                        <h5 class="push-10-t">Free 1 Iced Café'Latte<br>or Green Tea Latte or Green Tea Latte or Iced Chocolate 16 oz.</h5>
                                        <div class="select-box">
                                            <div class="popover-wp"><i class="fa fa-check"></i></div>
                                            <p>Select</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-md-offset-2">
                                <div class="form-group margin-0">
                                    <button class="btn btn-sm btn-block btn-primary" type="submit">Get Offer</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    </form>
                    <!-- END Lucky Register Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../Cores/validation/validate_wp_select.js"></script>

<?php include '../Cores/template/footer_public.php' ?>