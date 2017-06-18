<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();
    try
    {
        if(!empty($_SESSION['country']))
        {

                if(!empty($_POST['wp_check'])) {

                    $wp_check = $_POST['wp_check'];
                    $check = '"'.implode('", "',$wp_check).'"';

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
                        $temp = 0;//dev=0;prod=-1
                        $stmt->bindParam(':welcomepack_id', $welcomepacks[$i]['id']);
                        $stmt->bindParam(':quantity', $temp);
                        $stmt->execute();

                    }
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
                //var_dump($wp);

                unset($_POST);

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


    function conversTime($Timestamp) {

        $source = substr($Timestamp,0,10);
        $date = new DateTime($source);
        $dateConvers = $date->format('d-m-Y'); // 31.07.2012

    }


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
                                                <img src="<?php echo Settings::full_url(); ?>assets/img/upload/w<?php echo $wp[$i]['welcomepack_id'];?>.jpg" alt="">
                                            </div>
                                            <div class="col-md-8 redeem-gift-r">
                                                <h4><?php echo $wp[$i]['name']; ?></h4>
                                                <h5 class="push-5-t"><?php echo $wp[$i]['code'].'-'.$wp[$i]['welcomepack_id'].$wp[$i]['id']; ?></h5>
                                                <p class="p-desc"><?php echo $wp[$i]['description'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 i5-nopad">
                                            <h5 class="push-10-t text-left">Terms & Conditions</h5>
                                            <ul class="p-term push-15">
                                                <?php echo $wp[$i]['term'] ?>
                                            </ul>
                                        </div>
                                        <?php if ( $i == $a_count ) {?>
                                                    <div class="form-group redeem-gift-btn">
                                                        <p class="p-desc"><br>More shopping experience.</p>
                                                        <a href="https://thailandgrandsale.co">
                                                            <button class="btn btn-sm btn-block btn-primary btn-p-5">More</button>
                                                        </a>
                                                    </div>
                                        <?php } else {?>
                                                    <div class="form-group redeem-gift-btn" href="#myCarousel" data-slide="next">
                                                        <p class="p-desc">Please save your pack for redemption.</p>
                                                        <a href="">
                                                            <button class="btn btn-sm btn-block btn-primary btn-p-5">Save Photo</button>
                                                        </a>
                                                    </div>
                                        <?php } ?>
                                    </div>
                            <?php } //.for loop Coupon ?>
                                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo '<pre>'.print_r($_SESSION, true).'</pre>'; ?>

<script>
    $('#myCarousel').carousel({
      wrap: false
    });
</script>

<?php include '../Cores/template/footer_public.php' ?>
