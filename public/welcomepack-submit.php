<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();
    try
    {
        if(!empty($_POST))
        {

            $_SESSION['country'] = $_POST['country'];

            if($_SESSION['country'] == 'Thailand')
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
                //random algorithm
                $sql = 'SELECT
                            *
                        FROM
                            `welcomepacks`
                        WHERE
                            `limits` > 0 AND
                            `allocate_now`> 0';
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $welcomepacks = $stmt->fetchAll();
                $ran = rand(0, sizeof($welcomepacks)-1);


                $sql = 'INSERT INTO `welcomepacks_registers`(`country`, `welcomepack_id`) VALUES (:country, :welcomepack_id)';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':country', $_SESSION['country']);
                $stmt->bindParam(':welcomepack_id', $welcomepacks[$ran]['id']);
                $stmt->execute();

                $sql = 'UPDATE
                            `welcomepacks`
                        SET
                            `limits` = `limits` + :quantity,
                             `allocate_now` = `allocate_now` + :quantity
                        WHERE
                            id = :welcomepack_id';
                $stmt = $db->prepare($sql);
                $temp = -1;
                $stmt->bindParam(':welcomepack_id', $welcomepacks[$ran]['id']);
                $stmt->bindParam(':quantity', $temp);
                $stmt->execute();

                $sql = 'SELECT
                            *
                        FROM
                            `welcomepacks_registers`
                        ORDER BY id DESC LIMIT 1';

                $stmt = $db->prepare($sql);
                $stmt->execute();

                $sql = 'SELECT
                            *
                        FROM
                            `welcomepacks`
                        WHERE
                          welcomepack_id';


                $sql = 'SELECT
                        *
                        FROM
                            `welcomepacks` wp
                        INNER JOIN `welcomepacks_registers` wpr ON wp.id = wpr.welcomepack_id
                        ORDER BY wpr.id DESC LIMIT 1';

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':welcomepack_id', $welcomepacks[$ran]['id']);
                $stmt->execute();
                $wp = $stmt->fetch();



            }

            $_SESSION['welcomepack'] = $wp;
            $_POST = Null;

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

    $source = substr($wp['timestamp'],0,10);
    $date = new DateTime($source);
    $dateConvers = $date->format('d-m-Y'); // 31.07.2012

?>

<div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <div class="text-center">
                        <h1 class="push-20-t">Free WelcomePack</h1>
                        <div class="col-xs-12 col-md-offset-1 redeem-gift">
                            <div class="col-md-4 redeem-gift-l">
                                <img src="http://via.placeholder.com/150x150" alt="">
                            </div>
                            <div class="col-md-8 redeem-gift-r">
                                <h4><?php echo $wp['name']; ?></h4>
                                <h5><?php echo $wp['code'].'-'.$wp['limits']; echo $wp['id']?></h5>
                                <p class="push-10-t p-label">Please redeem in</p>
                                <h5><?php echo $dateConvers; ?></h5>
                                <p class="p-desc"><?php echo $wp['description'] ?></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-offset-1 text-left redeem-gift-term">
                            <h5>Terms & Conditions</h5>
                            <ul>
                                <?php echo $wp['term'] ?>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row push-10-t text-center">
                            <h5>Welcome to the Land of Smiles
                                <br>with superb shopping experiences</h5>
                            <a href="https://thailandgrandsale.co">
                                <button class="btn btn-sm btn-block btn-primary">More</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo '<pre>'.print_r($_SESSION, true).'</pre>'; ?>

<?php include '../Cores/template/footer_public.php' ?>
