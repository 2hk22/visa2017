<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();
    try
    {
        //google re capcha
        if(!empty($_POST))
        {

            if($_POST['country'] == 'Thailand')
            {
                header('Location: oops.php', true, 302);
               exit;
            }
            if(isset($_COOKIE['already'])) {
                header('Location: already.php', true, 302);
                exit;
            }
            else
            {
                //setcookie('already', 1, time() + (86400 * 30));

                $_SESSION['country'] = $_POST['country'];

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
            <div class="col-sm-12">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-30-t">Greeting you with <br>Thailand Grand Sale</h1>
                        <p  class="push-20">Choose your welcome offer</p>
                    </div>

                    <!-- Lucky Register Form -->
                    <form class="form-horizontal push-10-t" id="wp_form" action="welcomepack-submit.php" method="POST">
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
                    </form>
                    <!-- END Lucky Register Form -->
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../Cores/template/footer_public.php' ?>