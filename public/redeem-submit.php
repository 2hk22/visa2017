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
            if($encode_captcha !== htmlspecialchars($encode_captcha) || $encode_captcha !== RemoveSimbols($_POST['captcha'])) // Detect Fucking Hacker
            {
                header('Location:oops.php', true, 302);
                exit;

            }else{

                if(!empty($_POST))
                {
                    $encode_country = htmlspecialchars($_POST['country'], ENT_QUOTES);
                    $encode_approval_code = htmlspecialchars($_POST['approval_code'], ENT_QUOTES);
                    $encode_merchant_code = htmlspecialchars($_POST['merchant_code'], ENT_QUOTES);
                    $encode_spending = htmlspecialchars($_POST['spending'], ENT_QUOTES);
                    unset($_POST);

                    if($encode_country !== htmlspecialchars($encode_country)) // Detect Fucking Hacker
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                    elseif($encode_approval_code !== htmlspecialchars($encode_approval_code))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                    elseif($encode_merchant_code !== htmlspecialchars($encode_merchant_code))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                    elseif($encode_spending !== htmlspecialchars($encode_spending))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                    else // Form is collected,Thank For Post
                        {
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


    $padded = str_pad((string)$mr['id'], 2, "0", STR_PAD_LEFT);

    //$source = substr($mr['timestamp'],0,10);
    //$date = new DateTime($source);
    //$dateConvers = $date->format('d-m-Y'); // 31.07.2012

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
                                <h3><?php echo htmlspecialchars($mr['item']); ?></h3>
                                <h5><?php echo htmlspecialchars($mr['merchant_code']).'-'.$padded.'-'.htmlspecialchars($mr["member_redeem_id"])?></h5>
                                <p class="p-desc">Present this message screen with your Visa Sale slip at <?php echo htmlspecialchars($mr['description'])?>to get<?php echo $mr['item']; ?></p>
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
