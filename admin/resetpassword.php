<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
$db = Settings::database();
    if(hash_equals($_SESSION['token'], $_GET['token'])){
    $_SESSION['admin_id'] = '';
    if (empty($_SESSION['token'])) {
                if (function_exists('mcrypt_create_iv')) {
                    $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                } else {
                    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                }
            }
    $token = $_SESSION['token'];
        if (!empty($_POST['token'])) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                try
                {
                    if($_POST['password'] == $_POST['password2']){
                        $options = [
                        'cost' => 10,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                        ];
                        $newpass = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
                        $sql = 'UPDATE `administrators` SET `available` = 1,`password` = :newpass  WHERE username LIKE :username';
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':username', $_SESSION['username']);
                        $stmt->bindParam(':newpass', $newpass);
                        $stmt->execute();
                        header('Location: index.php', true, 302);
                        exit();
                    } else {
                        echo("
                            <p style='color:red;'>Password has been incorrect,pls dude retry!</p>
                        ");
                    }
                    
                }//try
                catch (PDOException $e)
                    {
                        echo $e->getMessage();
                    }
                } else {
                    header('Location:oops.php', true, 302); exit;
                }       
            }
        } else {
            header('Location:oops.php', true, 302); exit;
        }
?>

<div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <!-- Reset Password Title -->
                    <div class="text-center">
                        <h1 class="push-20-t">Reset Password</h1>
                        <p class="push-10-t">Enter your new password</p>
                    </div>
                    <!-- END Reset Password Title -->

                    <!-- Reset Password Form -->
                    <form class="js-validation-login form-horizontal push-30-t" action="resetpassword.php" method="POST">
                        <div class="form-group">
                            <label for="username">Password</label>
                            <input class="form-control" type="Password" id="password" name="password" placeholder="Enter Password..">
                        </div>
                        <div class="form-group">
                            <label for="country">Password (again)</label>
                            <input class="form-control" type="Password" id="password2" name="password2" placeholder="Enter Password..">
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <button class="btn btn-sm btn-block btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    </form>
                    <!-- END Reset Password Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../Cores/template/footer.php' ?>
