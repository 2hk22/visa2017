<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_public.php' ?>

<?php
    $db = Settings::database();

        function PassEncryption($string, $salt, $Type){ // if Type=0 : Encrypt, if Type=1: Decrypt
            // employeee $salt=userID
            $key="MVjxLn5exXYZ2F8A1321";
            $key=$salt.$key;
            if(!$Type){ // Encrypt
                $result=base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
            }
            else{
                if(strlen($string)>20){ // string 2 Decrypt > 20
                    $result=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
                }else{
                    $result=$string;
                }
            }
            return $result;
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
        $hashing = (string)(PassEncryption(trim($_POST["password"]), 57, 0));

        $ran = rand(0,10000);

        $sql = 'UPDATE
                `administrators`
                    SET
                    sId = :sId';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':sId', $ran);
        $stmt->execute();

        $isLogin = strcmp($hash,$hashing);

        //echo $hash.'***'.$hashing.'***'.$isLogin;

        if($isLogin === 0){
        header('Location: main.php', true, 302);
            exit();
        }
        else{
            header('Location: oops.php', true, 302);
            exit();
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
                                <button class="btn btn-sm btn-block btn-primary" type="submit">Log in</button>
                            </div>
                        </div>
                    </form>
                    <!-- END Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../Cores/template/footer.php' ?>
