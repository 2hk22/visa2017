<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>


<?php
    $db = Settings::database();
    function Encode($var) {
                $var = htmlentities(htmlentities($var, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
                $var = preg_replace('/[^\p{L}\p{N}\s]/u', '', $var);
                return $var;
    }
    function Encode2($var) {
                $var = htmlentities(htmlentities($var, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
                return $var;
    }
    if (!empty($_POST['token'])) {
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
            try
            {
                if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"])
                {
                    $encode_captcha = Encode($_POST["captcha"]);
                    if(strlen($_POST["captcha"]) !== strlen($encode_captcha))
                    {
                        header('Location:oops.php', true, 302);
                        exit;

                    }else{

                        if(!empty($_POST))
                        {
                            $encode_country = Encode($_POST['country']);
                            $encode_approval_code = Encode($_POST['approval_code']);
                            $encode_merchant_code = Encode($_POST['merchant_code']);
                            $encode_spending = Encode($_POST['spending']);
                            

                            if(strlen($_POST['country']) !== strlen($encode_country)) 
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
                            elseif(strlen($_POST['approval_code']) !== strlen($encode_approval_code))
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
                            elseif(strlen($_POST['merchant_code']) !== strlen($encode_merchant_code))
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
                            elseif(strlen($_POST['spending']) !== strlen($encode_spending))
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
                            else // Form is collected,Thank For Post
                                {
                                //unset($_POST);
                                if($encode_country == 'Thailand')// if thailand redirect to winprize page
                                {
                                    header('Location:winprize.php', true, 302);
                                    exit;
                                }
                                elseif($encode_merchant_code === null)
                                {
                                    header('Location:oops.php', true, 302);
                                    exit;
                                }
                                elseif($encode_spending < 1000)
                                {
                                    header('Location:oops.php', true, 302);
                                    exit;
                                }
                                else //Whitelist
                                {
                                    $sql = 'SELECT
                                                *,
                                                mr.id member_redeem_id,
                                                r.id redeem_id
                                            FROM
                                                    `members_redeems` mr
                                                INNER JOIN `redeems` r ON mr.redeem_id = r.id
                                            WHERE
                                                approval_code LIKE :approval_code';
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':approval_code', $encode_approval_code);
                                    $stmt->execute();
                                    $mr = $stmt->fetch();
                                    if ($mr['approval_code'] == $encode_approval_code) {
                                        echo "
                                            <div class='modals redeem-modals'>
                                                <div class='modals-warp animated bounceInDown'>
                                                    <h1 class='push-30-t'>You already have <br class='visible-xs'> this privilege.</h1>
                                                    <button class='btn btn-block btn-closes btn-primary'>View Your Privilege</button>
                                                </div>
                                            </div>
                                            ";
                                    }
                                    if(!empty($mr))
                                    {
                                        $mr['state'] = 'ready';
                                    }
                                    else
                                    {
                                        $sql = 'SELECT
                                                    *
                                                FROM `redeems` ';
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                        $mr = $stmt->fetch();
                                        if($mr['allocate_now'] == 0) // Stock is Empty!
                                        {
                                            header('Location:winprize.php', true, 302);
                                            exit;
                                        }
                                        //random algorithm
                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    `redeems`
                                                WHERE
                                                    merchant_code LIKE :merchant_code AND
                                                    amount > 0  AND
                                                    allocate_now > 0  AND
                                                    crireria < :spending';
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':merchant_code', $encode_merchant_code);
                                        $stmt->bindParam(':spending', $encode_spending);
                                        $stmt->execute();
                                        $redeems = $stmt->fetchAll();

                                        if(empty($redeems)) // Stock is Empty!
                                        {
                                            header('Location:winprize.php', true, 302);
                                            exit;
                                        }

                                        $ran = rand(0, sizeof($redeems)-1);

                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    `members_redeems`
                                                WHERE
                                                    redeem_id LIKE :redeem_id';
                                        $stmt = $db->prepare($sql);

                                        $stmt->bindParam(':redeem_id', $redeems[$ran]['id']);
                                        $stmt->execute();
                                        $members_redeems = $stmt->fetchAll();

                                        $sql = 'INSERT INTO
                                                    `members_redeems`(
                                                        `id`,
                                                        `redeem_id`,
                                                        `spending`,
                                                        `approval_code`,
                                                        `country`
                                                    )
                                                VALUES (
                                                    :id,
                                                    :redeem_id,
                                                    :spending,
                                                    :approval_code,
                                                    :country
                                                )';
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':id', $id);
                                        $stmt->bindParam(':redeem_id', $redeems[$ran]['id']);
                                        $stmt->bindParam(':spending', $encode_spending);
                                        $stmt->bindParam(':approval_code', $encode_approval_code);
                                        $stmt->bindParam(':country', $encode_country);
                                        $stmt->execute();

                                        $sql = 'UPDATE
                                                    `redeems`
                                                SET
                                                    `amount` = `amount` + :quantity,
                                                    `allocate_now` = `allocate_now` + :quantity
                                                WHERE
                                                    id = :redeem_id';
                                        $stmt = $db->prepare($sql);
                                        $temp = -1;
                                        $stmt->bindParam(':redeem_id', $redeems[$ran]['id']);
                                        $stmt->bindParam(':quantity', $temp);
                                        $stmt->execute();

                                        $sql = 'SELECT
                                                    *,
                                                    mr.id member_redeem_id,
                                                    r.id redeem_id
                                                FROM
                                                    `members_redeems` mr
                                                    INNER JOIN `redeems` r ON mr.redeem_id = r.id
                                                WHERE
                                                    approval_code LIKE :approval_code';
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':approval_code', $encode_approval_code);
                                        $stmt->execute();
                                        $mr = $stmt->fetch();
                                        //var_dump($mr);
                                        $mr['state'] = 'new';
                                    }

                                }
                            }
                        }
                        else
                        {
                            header('Location:oops.php', true, 302);
                            exit;
                        }

                    }
                }
                else
                {header('Location:oops.php', true, 302); exit;}

            }//try
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        } else {
            header('Location:oops.php', true, 302); exit;
        }
    }
    


    $padded = str_pad((string)$mr['id'], 2, "0", STR_PAD_LEFT);

    //Encode Output
    $clean_padded = Encode($padded);
    $clean_item = Encode($mr['item']);
    $clean_merchant_code = Encode($mr['merchant_code']);
    $clean_member_redeem_id = Encode($mr['member_redeem_id']);
    $clean_description = Encode2($mr['description']);

        // Detect Blacklist
        if(strlen($padded) !== strlen($clean_padded))
            {
                header('Location:oops.php', true, 302);
                exit;
            }
                elseif(strlen($mr['item']) !== strlen($clean_item))
                {
                    header('Location:oops.php', true, 302);
                    exit;
                }
                    elseif(strlen($mr['merchant_code']) !== strlen($clean_merchant_code))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                        elseif(strlen($mr['member_redeem_id']) !== strlen($clean_member_redeem_id))
                        {
                            header('Location:oops.php', true, 302);
                            exit;
                        }
                            elseif(strlen($mr['description']) !== strlen($clean_description))
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
                            
        //Congrat! You're Welcome ;}

    //$source = substr($mr['timestamp'],0,10);
    //$date = new DateTime($source);
    //$dateConvers = $date->format('d-m-Y'); // 31.07.2012

    //Clean Session
    $_SESSION = array();
    session_destroy();
?>

 <div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-10">Congratulation!<br>You won</h1>
                        <div class="col-xs-12 col-md-offset-1 redeem-gift">
                            <div class="col-md-4 redeem-gift-l">
                            <div class="circle-container">
                                <img src="<?php echo Settings::full_url(); ?>assets/img/upload/gift.png" class="circle-img" alt="">
                            </div>
                            </div>
                            <div class="col-md-8 redeem-gift-r">
                                <h3><?php echo $clean_item; ?></h3>
                                <h5><?php echo $clean_merchant_code.'-'.$clean_padded.'-'.$clean_member_redeem_id;?></h5>
                                <p class="p-desc">Present this message screen with your Visa Sale slip at <?php echo $clean_description ?>to get<?php echo $clean_item; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-1 text-left redeem-gift-term">
                            <h5>Terms & Conditions</h5>
                            <ul>
                                <li>Customer must present Visa sales slip with qualified purchase amount</li>
                                <li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li>
                                <li>The offer is valid from 15 June – 31 August 2017</li>
                                <li>The offer cannot be redeemed or exchanged for cash</li>
                                <li>Terms and conditions apply for usage of each offer</li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row push-10-t text-center">
                            <h5 id="save_text">Please Capture Screen All Coupon <br class='visible-xs'>in Your Pack For Redemption.</h5>
                            <h5 id="simply_text">Entitle a chance to win <br class="visible-xs">“A Trip to Thailand” <br class="visible-xs">grand prize package here!</h5>
                            <a href="https://www.visa-promotions.com/mepa/tgs">
                                <button class="btn btn-sm btn-block btn-primary">Simply click</button>
                            </a>
                        </div>
                    </div>
                    <div class="form-group redeem-gift-btn redeem-gift-save redeem-gift-save2 none" id="save_image_container">
                        <button class="btn btn-sm btn-block btn-primary btn-p-5" id="save_image">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='modals redeem-modals2 none' id="is-notChrome">
    <div class='modals-warp animated bounceInDown'>
        <h1 class='push-30-t'>Please Capture Screen<br class='visible-xs'>All Coupon in Your Pack<br class='visible-xs'>For Redemption.</h1>
        <button class='btn btn-block btn-closes2 btn-primary'>Get Start</button>
    </div>
</div>

<?php //var_dump($mr) ?>

<?php include '../Cores/template/footer_public.php' ?>

<script>

$( function() {
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome) {
        $("#save_image_container").removeClass('none')
        $('#simply_text').hide()
        console.log('helppp')
    }else{
        $("#is-notChrome").removeClass('none')
        $('#save_text').hide()
    }
});

$('.btn-closes').click(function(){
    $('.redeem-modals,.btn-closes').addClass("none");
});


document.querySelector('#save_image').addEventListener('click', function() {
    html2canvas(document.querySelector('body'), {
        onrendered: function(canvas) {
            // document.body.appendChild(canvas);

          return Canvas2Image.saveAsJPEG(canvas);
        }
    });
});

$("#save_image").click(function() {
    setTimeout(function() {
        $("#save_image").fadeOut( "slow" )
        $("#save_text").fadeOut( "slow" )
        $("#simply_text").fadeIn( "slow" )
    },600);
});

</script>

<script>
jQuery(function(){
    $('.btn-closes').click(function(){
        $('.redeem-modals,.btn-closes').addClass("none");
    });
    $('.btn-closes2').click(function(){
        $('.redeem-modals2,.btn-closes2').addClass("none");
    });
});
</script>
