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
        if (!empty($_GET['w_id'])) {

            $sql = 'SELECT
                    *
                    FROM
                        `coupons`
                    WHERE
                        w_id LIKE :id ';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_GET['w_id']);
            $stmt->execute();
            $cl = $stmt->fetchAll();
            //var_dump($cl);

            $sql = 'SELECT
                    *
                    FROM
                        `welcomepacks`
                    WHERE
                        id LIKE :id  ';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_GET['w_id']);
            $stmt->execute();
            $wp = $stmt->fetch();
            //var_dump($wp);


        }else{
            header('Location: welcomepack-list.php', true, 302);
            exit;
        }
    }
?>

<div class="content content-boxed">
    <div class="block">
        <div class="block-header">
            <h4><i class="fa fa-users push-5-r" ></i>WelcomePack List &nbsp; | &nbsp;
            <i class="fa fa-plus"></i> Add Coupon : <?php echo $wp['name']; ?></h4>
            <div class="block-content">
                <div class="col-xs-12 col-md-5 col-lg-5 col-lg-offset-1">
                    <div class="push-30-t push-50 admin-panael">
                        <form class="form-horizontal push-30-t" id="validate_admin_coupon" action="welcomepack-coupon-add.php" method="POST">
                            <div class="form-group">
                                <label class="col-xs-2 control-label">Coupon</label>
                                <div class="col-xs-8">
                                    <input class="form-control" type="text" id="coupon" name="coupon" placeholder="Coupon ID" required />
                                </div>
                            </div>
                            <div class="form-group visiblity-none">
                                <input class="form-control" type="text" value="<?php echo $_GET['w_id'];?>" id="w_id" name="w_id" required />
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-default btn-full">Add Coupon</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
<?php if(!empty($cl)) { ?>
                <div class="col-xs-12 col-md-7 col-lg-5">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-hover js-dataTable-full dataTable no-footer display" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center table-col-1 no-index">id</th>
                                    <th class="text-center table-col-1 no-index">w code</th>
                                    <th class="text-center table-col-3 no-index">Status</th>
                                    <th class="text-center no-index">Coupon Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cl as $cl) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $cl['id']; ?></td>
                                        <td class="text-center"><?php echo $wp['code']; ?></td>
                                        <td class="text-center">
                                            <?php if($cl['status'] == 1){echo"Available";}else{echo"Used";}?>
                                        </td>
                                        <td class="text-center"><?php echo $cl['coupon']?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include '../Cores/template/footer_admin.php' ?>

