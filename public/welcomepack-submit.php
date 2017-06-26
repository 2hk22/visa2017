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
                if(!empty($_SESSION['country']))
                {
                        if(isset($_COOKIE['already'])) {
                            header('Location: already.php', true, 302);
                            exit;
                        }
                        elseif(!empty($_POST['wp_check'])) {
                            $wp_check = $_POST['wp_check'];
                            for($i = 0; $i < sizeof($wp_check);$i++)
                            {
                                $encode_wp_check[$i] = Encode($wp_check[$i]);
                                if(strlen($wp_check[$i]) !== strlen($encode_wp_check[$i]))
                                {
                                    header('Location:oops.php', true, 302);
                                    exit;
                                }
                                //Grab is Choose
                                else if($encode_wp_check[$i] == 1){
                                        //Query GrabCoupons
                                        $sql = 'SELECT
                                            *
                                        FROM
                                            `grab_coupons`
                                        WHERE
                                            `status` = 1
                                        LIMIT 1';
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                        $grabcoupon = $stmt->fetch();

                                        //Decrement GrabCoupons
                                        $sql = 'UPDATE
                                                `grab_coupons`
                                                SET
                                                    `status` = 0
                                                WHERE
                                                    id = :grabcoupon_id';
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':grabcoupon_id', $grabcoupon['id']);
                                        $stmt->execute();
                                }
                            $check = '"'.implode('", "',$encode_wp_check).'"';
                            }

                            //Check Empty Grab Coupon
                            if (strpos($check, '1') !== false) {
                                if($grabcoupon['id'] == Null){
                                    $check = substr($check,5);
                                }
                            }

                            if (strpos($check, '2') == false && strpos($check, '3') == false) {
                                if($grabcoupon['id'] == Null){
                                    header('Location: winprize.php', true, 302);exit;
                                }
                            }

                            $sql = 'SELECT
                                        *
                                    FROM
                                        `welcomepacks`
                                    WHERE
                                        `limits` > 0 AND
                                        `allocate_now`> 0 AND
                                        `id` IN (' . $check . ') ';
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $welcomepacks = $stmt->fetchAll();
                            $a_count = sizeof($welcomepacks)-1;
                            $count = sizeof($welcomepacks);
                            //var_dump($welcomepacks);

                            for( $i=0; $i <=$a_count; $i++) {

                                //Add wp History
                                $sql = 'INSERT INTO
                                        `welcomepacks_registers`(
                                            `country`,
                                            `welcomepack_id`
                                            )
                                        VALUES (
                                        :country,
                                        :welcomepack_id
                                        )';
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':country', $_SESSION['country']);
                                $stmt->bindParam(':welcomepack_id', $welcomepacks[$i]['id']);
                                $stmt->execute();

                                //Decrement Stock
                                $sql = 'UPDATE
                                        `welcomepacks`
                                        SET
                                            `limits` = `limits` + :quantity,
                                            `allocate_now` = `allocate_now` + :quantity
                                        WHERE
                                            id = :welcomepack_id';
                                $stmt = $db->prepare($sql);
                                $temp = -1;//dev=0;prod=-1
                                $stmt->bindParam(':welcomepack_id', $welcomepacks[$i]['id']);
                                $stmt->bindParam(':quantity', $temp);
                                $stmt->execute();

                            }
                        }
                        else {
                            header('Location:oops.php', true, 302); exit;
                        }
                        //Query Redeem List
                        $sql = "SELECT
                                *
                                FROM
                                    `welcomepacks` wp
                                INNER JOIN `welcomepacks_registers` wpr ON wp.id = wpr.welcomepack_id
                                ORDER BY wpr.id DESC LIMIT ".$count;

                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':welcomepack_id', $welcomepacks[]['id']);
                        $stmt->execute();
                        $wp = $stmt->fetchAll();
                        if(empty($wp)){
                            header('Location: winprize.php', true, 302);exit;
                        }
                        //var_dump($wp);

                        unset($_POST);

                        setcookie('already', 1, time() + (86400 * 30));//1days

                }//.if(!empty($_SESSION['country']))
                else
                {
                    header('Location: oops.php', true, 302);
                    exit;
                }
            }//.try
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        } else {
            header('Location: oops.php', true, 302);
            exit;
        }
    }
    


    function conversTime($Timestamp) {

        $source = substr($Timestamp,0,10);
        $date = new DateTime($source);
        $dateConvers = $date->format('d-m-Y'); // 31.07.2012

    }

    //Encode Output
    if(!empty($grabcoupon['promocode'])){
        $clean_promocode = Encode($grabcoupon['promocode']);
        if(strlen($grabcoupon['promocode']) !== strlen($clean_promocode))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
        }
    }


    for( $i=0; $i <= $a_count; $i++) {
        $clean_welcomepack_id = Encode($wp[$i]['welcomepack_id']);
        $clean_code = Encode($wp[$i]['code']);
        $clean_id = Encode($wp[$i]['id']);
        $clean_description = Encode2($wp[$i]['description']);
        //$clean_term = Encode($wp[$i]['term']);
        //$clean_name = Encode2($wp[$i]['name']);
        
        // Detect Blacklist
        if(strlen($wp[$i]['welcomepack_id']) !== strlen($clean_welcomepack_id))
            {
                header('Location:oops.php', true, 302);
                exit;
            }
                elseif(strlen($wp[$i]['code']) !== strlen($clean_code))
                    {
                        header('Location:oops.php', true, 302);
                        exit;
                    }
                        elseif(strlen($wp[$i]['id']) !== strlen($clean_id))
                        {
                            header('Location:oops.php', true, 302);
                            exit;
                        }
                            elseif(strlen($wp[$i]['description']) !== strlen($clean_description))
                            {
                                header('Location:oops.php', true, 302);
                                exit;
                            }
    }
    //Congrat! You're Welcome ;}
    $_SESSION = array();
    session_destroy();
?>

<div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden i6-nopad">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-20-t">Free WelcomePack</h1>
                            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner">
                            <?php
                            for( $i=0; $i <= $a_count; $i++) {
                            if ( $i == 0 ) {?>
                                    <div class="item active">
                            <?php } else {?>
                                    <div class="item">
                            <?php } ?>
                                        <h5 class="push-10-t">Coupon <?php echo $i+1 ." of ".$count;?></h5>
                                        <div class="col-xs-12 redeem-gift">
                                            <div class="col-md-4 redeem-gift-l">
                                                <img src="<?php echo Settings::full_url();?>assets/img/upload/w<?php echo $wp[$i]['welcomepack_id'].'.jpg';?>" alt="">
                                            </div>
                                            <div class="col-md-8 redeem-gift-r">
                                                <h4><?php echo $wp[$i]['name']; ?></h4>
                                                <?php if ($wp[$i]['code'] == "GCS") {?>
                                                        <h5 class="push-5-t" style="color:#14b86a;"><?php echo $grabcoupon['promocode']; ?></h5>
                                                    <?php } else {?>
                                                        <h5 class="push-5-t"><?php echo $wp[$i]['code'].'-'.$wp[$i]['welcomepack_id'].$wp[$i]['id']; ?></h5>
                                                    <?php } ?>
                                                <p class="p-desc"><?php echo $wp[$i]['description']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 i5-nopad">
                                            <h5 class="push-10-t text-left">Terms & Conditions</h5>
                                            <ul class="p-term push-15">
                                                <?php echo $wp[$i]['term']; ?>
                                            </ul>
                                        </div>
                                        <?php if ( $i == $a_count ) {?>
                                                    <div class="form-group redeem-gift-btn">
                                                        <p class="p-desc"><br>More shopping experience.</p>
                                                        <a href="https://thailandgrandsale.co">
                                                            <button class="btn btn-sm btn-block btn-primary btn-p-5" >See More</button>
                                                        </a>
                                                    </div>
                                        <?php } else {?>
                                                        <div class="form-group redeem-gift-btn" href="#myCarousel" data-slide="next">
                                                        <p class="p-desc">Please save your pack for redemption.</p>
                                                        <a href="">
                                                            <button class="btn btn-sm btn-block btn-primary btn-p-5" id="next_btn<?php echo $i+1; ?>" >More Offer</button>
                                                        </a>
                                                    </div>
                                        <?php } ?>
                                    </div>
                            <?php } //.for loop Coupon ?>
                                    <div class="form-group redeem-gift-btn redeem-gift-save none" id="save_image_container">
                                        <button class="btn btn-sm btn-block btn-primary btn-p-5" id="save_image">Save</button>
                                    </div>
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class='modals redeem-modals none' id="is-notChrome">
    <div class='modals-warp animated bounceInDown'>
        <h1 class='push-30-t'>Please Capture Screen<br class='visible-xs'>All Coupon in Your Pack<br class='visible-xs'>For Redemption.</h1>
        <button class='btn btn-block btn-closes btn-primary'>Get Start</button>
    </div>
</div>

<?php //echo '<pre>'.print_r($_SESSION, true).'</pre>'; ?>
<script>

//crome canuse html2canvas well
$( function() {
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome) {
        $("#save_image_container").removeClass('none')
        console.log('helppp')
    }else{
        $("#is-notChrome").removeClass('none')
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
    },600);
});

$("#next_btn1").click(function() {
    setTimeout(function() {
        $("#save_image").show()
    },595);
});

$("#next_btn2").click(function() {
    setTimeout(function() {
        $("#save_image").show()
    },595);
});

$('#myCarousel').carousel({
  wrap: false
});

</script>

<?php include '../Cores/template/footer_public.php' ?>
