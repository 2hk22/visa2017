<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<script>
jQuery(function(){
    $('.btn-closes').click(function(){
        $('.redeem-modals,.btn-closes').addClass("none");
    });
});
</script>

<?php
    $db = Settings::database();

    try
    {

        if(!empty($_POST))
        {
            $_SESSION['country'] = $_POST['country'];
            $_SESSION['approval_code'] = $_POST['approval_code'];
            $_SESSION['merchant_code'] = $_POST['merchant_code'];
            $_SESSION['spending'] = $_POST['spending'];

            if($_SESSION['country'] == 'Thailand')
            {
                header('Location:oops.php', true, 302);
                exit;
            }
            elseif($_SESSION['merchant_code'] === null)
            {
                header('Location:oops.php', true, 302);
                exit;
            }
            elseif($_SESSION['spending'] < 1000)
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
                $stmt->bindParam(':approval_code', $_POST['approval_code']);
                $stmt->execute();
                $mr = $stmt->fetch();

                if ($mr['approval_code'] == $_POST['approval_code']) {
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
                    $stmt->bindParam(':merchant_code', $_POST['merchant_code']);
                    $stmt->bindParam(':spending', $_POST['spending']);
                    $stmt->execute();
                    $redeems = $stmt->fetchAll();
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
                                    `approval_code`
                                )
                            VALUES (
                                :id,
                                :redeem_id,
                                :spending,
                                :approval_code
                            )';
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':redeem_id', $redeems[$ran]['id']);
                    $stmt->bindParam(':spending', $_POST['spending']);
                    $stmt->bindParam(':approval_code', $_POST['approval_code']);
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
                    $stmt->bindParam(':approval_code', $_POST['approval_code']);
                    $stmt->execute();
                    $mr = $stmt->fetch();
                    $mr['state'] = 'new';
                }

                $_SESSION['redeem'] = $mr;
           }
        }
        else
        {
            header('Location:oops.php', true, 302);
            exit;
        }


    }//try
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }


    $padded = str_pad((string)$mr['id'], 3, "0", STR_PAD_LEFT);

    $source = substr($mr['timestamp'],0,10);
    $date = new DateTime($source);
    $dateConvers = $date->format('d-m-Y'); // 31.07.2012

?>



 <div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-30-t">Your reward</h1>
                        <div class="col-xs-12 col-md-offset-1 redeem-gift">
                            <div class="col-md-4 redeem-gift-l">
                                <img src="http://via.placeholder.com/150x150" alt="">
                            </div>
                            <div class="col-md-8 redeem-gift-r">
                                <h3><?php echo $mr['item']; ?></h3>
                                <h5><?php echo $mr['merchant_code'].'-'.$padded.'-'.$mr["member_redeem_id"]?></h5>
                                <p class="push-10-t p-label">Please redeem in</p>
                                <h5><?php echo $dateConvers; ?></h5>
                                <p class="p-desc">Present this message screen with your Visa Sale slip at <?php echo $mr['description']?>to get<?php echo $mr['item']; ?></p>
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
                            <h5>Entitle a chance to <br class="visible-xs">win Grand Prize here!</h5>
                            <a href="https://www.visa-promotions.com/mepa/tgs">
                                <button class="btn btn-sm btn-block btn-primary">Click</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php //var_dump($mr) ?>

<?php include '../Cores/template/footer_public.php' ?>
