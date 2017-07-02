<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();
    function DateTimeDiff($strDateTime1,$strDateTime2)
        {
        return (strtotime($strDateTime2) - strtotime($strDateTime1))/  (60  ); // 1 Hour =  60*60
        }
    //Generate Token Prevent CSRF Attack!
    if (empty($_SESSION['token'])) {
                if (function_exists('mcrypt_create_iv')) {
                        $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                    } else {
                        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                    }
                }
    $token = $_SESSION['token'];
    
    function SendEmail() {
        $to = "oateerapat@gmail.com";
        $subject = "Request to Reset Passwords";
        $link = "http://localhost/visa2017/admin/resetpassword.php?token=";
        $message = $link.$_SESSION['token'];
        echo $message;
        $header = "From:memoryneung@gmail.com \r\n";
        $retval = mail($to,$subject,$message,$header);
        if( $retval == true )  
            {
            echo "Message sent successfully...";
            }
        else
            {
            echo "Message could not be sent...";
            }
    }

    //Forgot Password? Sent mail to Reset
    if (isset($_GET['sendmail'])) {
        SendEmail();
    }

    if(!empty($_POST))
    {
        $sql = 'SELECT
                    *
                FROM
                    `administrators`
                WHERE
                    username LIKE :username';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $user = $stmt->fetch();

        $_SESSION['admin_id'] = $_POST['username'];
        $hash = (string)$user['password'];
        $count = $user['count'];
        $available = $user['available'];
        $timestamp = $user['timestamp'];

        if ($user['available'] == 0) {
            echo "<br> Real Test <br>";
            $t_db= $timestamp;
            $t_now=date("Y-m-d H:i:s",time());
            echo $t_db . "<br>";
            echo $t_now . "<br>";
            $diff_time2 = DateTimeDiff($t_now,$t_db). "<br>";
            echo("
                    <p style='color:red;'>PLS! Waiting Until BlockTime Expired ... Time Left = ".(int)$diff_time2)."</p>
                " ;
            if($diff_time2 > 20){
                $sql = 'UPDATE `administrators` SET `available` = 1  WHERE username LIKE :username';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $_POST['username']);
                $stmt->execute();
                header('Location:index.php', true, 302); exit;
            }
        }
        else{
        //Verify Password
            if (password_verify(trim($_POST["password"]),$hash)) {
                $isLogin = 0;
            }
            else {
            $isLogin = '';
                if($count < 6) {
                    echo("
                        <p style='color:red;'>Wrong ID/Password Round $count,try again</p>
                    ");
                    $temp = 1;//dev=0;prod=1
                    $sql = 'UPDATE `administrators` SET `count` = `count` + :quantity WHERE username LIKE :username';
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':quantity', $temp);
                    $stmt->execute();
                }
                else {
                    $_SESSION['username'] = $_POST['username'];
                    $sql = 'UPDATE `administrators` SET `available` = 0,`count` = 1  WHERE username LIKE :username';
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->execute();
                }
            }

            if($isLogin === 0){
                if (!empty($_POST['token'])) {
                    if (hash_equals($_SESSION['token'], $_POST['token'])) {
                        try
                        {
                            $sql = 'UPDATE `administrators` SET `count` = 1  WHERE username LIKE :username';
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':username', $_POST['username']);
                            $stmt->execute();
                            header('Location: main.php', true, 302);
                            exit();
                        }//try
                        catch (PDOException $e)
                        {
                            echo $e->getMessage();
                        }
                    } else {
                        header('Location:oops.php', true, 302); exit;
                    }
                
                }
            }
        }
    }
?>

<div class="bg-white animated fadeIn">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2">
                <div class="push-100-t">
                    <!-- Login Title -->
                    <div class="text-center">
                        <h1 class="push-20-t">Login</h1>
                        <p class="push-10-t">A perfect match for your project</p>
                    </div>
                    <!-- END Login Title -->

                    <!-- Login Form -->
                    <form class="js-validation-login form-horizontal push-30-t" action="index.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" type="username" id="username" name="username" placeholder="Enter Username..">
                        </div>
                        <div class="form-group">
                            <label for="country">Password</label>
                            <input class="form-control" type="Password" id="password" name="password" placeholder="Enter Password..">
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <a href="index.php?sendmail=true"><button class="btn btn-sm btn-block btn-primary">Password?</button></a>
                                <button class="btn btn-sm btn-block btn-primary" type="submit">Log in</button>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    </form>
                    <!-- END Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../Cores/template/footer.php' ?>
