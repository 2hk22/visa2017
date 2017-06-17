<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_admin.php' ?>

<?php
    $db = Settings::database();
    if(empty($_SESSION['admin_id']))
    {
        header('Location: index.php', true, 302);
        exit;
    }
    else
    {
        if (!empty($_POST['w_id'])) {
                 $sql = 'INSERT INTO
                    `coupons`(
                        `w_id`,
                        `coupon`
                )
                VALUES (
                        :w_id,
                        :coupon
                )';

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':w_id', $_POST['w_id']);
                $stmt->bindParam(':coupon', $_POST['coupon']);
                $stmt->execute();

                $redirect = 'Location: welcomepack-coupon.php?w_id='.$_POST['w_id'];

                header($redirect, true, 302);
                exit;
            }else{
                header('Location: welcomepack-list.php', true, 302);
                exit;
            }
    }
?>

<?php include '../Cores/template/footer_admin.php' ?>

