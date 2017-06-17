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
        if (!empty($_GET['edit_id'])) {

            $sql = 'SELECT
                    *
                    FROM
                        `welcomepacks`
                    WHERE
                        id LIKE :id  ';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_GET['edit_id']);
            $stmt->execute();
            $wp = $stmt->fetch();
            //var_dump($wp);

        }//.edit
    }
?>

<div class="content content-boxed">
    <div class="block">
        <div class="block-header">
            <h4><i class="fa fa-users push-5-r" ></i>WelcomePack List &nbsp; | &nbsp;
            <?php if (empty($_GET['edit_id'])) { ?>
            <i class="fa fa-plus"></i> Add New WelcomePack
            <?php }else{ ?>
            <i class="fa fa-pencil"></i> Edit WelcomePack : <?php echo $wp['name'] ?>
            <?php } ?>
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 admin-panael">
<?php  if (!empty($_GET['edit_id'])) { ?>
                        <form class="form-horizontal push-30-t" id="validate_admin_redeem-add" action="welcomepack-edit.php" method="POST">
                        <div class="form-group">
                            <label for="code" class="admin-panael">WelcomePack Code</label>
                            <input class="form-control" value="<?php echo $wp['code'];?>" type="text" id="wp_code" name="wp_code" placeholder="WelcomePack Code" required>
                        </div>
                        <div class="form-group">
                            <label for="item" class="admin-panael">WelcomePack Name</label>
                            <input class="form-control" value="<?php echo $wp['name'];?>" type="text" id="item" name="item" placeholder="Name" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Limit</label>
                            <input class="form-control" value="<?php echo $wp['limits'];?>" type="text" id="amount" name="amount" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Allocates(Item/Day)</label>
                            <input class="form-control" value="<?php echo $wp['allocate'];?>" type="text" id="allocate" name="allocate" placeholder="Amount allocate (Item/Day)" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Couponlist</label>
                                <input type="hidden" name="coupon" value="0" />
                                <input type="checkbox" name="coupon" value="1" <?php if($wp['coupon_list'] == 1){echo"checked";}?>>
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <input class="form-control" value="<?php echo $wp['description'];?>" type="text" id="description" name="description" placeholder="Description" required />
                        </div>
                        <div class="form-group">
                            <label for="terms" class="admin-panael">Terms & conditions</label>
                            <textarea class="form-control" type="text" id="terms" name="terms" placeholder="Terms & conditions" rows="5" required / ><?php echo $wp['term'];?></textarea>
                        </div>
                        <div class="form-group visiblity-none">
                            <input class="form-control" value="<?php echo $wp['id'];?>" type="text" id="id" name="id" required />
                        </div>
                        <div class="form-group push-30-t">
                            <button class="btn btn-sm btn-block admin-panael btn-primary" type="submit">Edit Welcome Pack</button>
                        </div>
                    </form>
<?php }else{ ?>
                    <form class="form-horizontal push-30-t" id="validate_admin_redeem-add" action="welcomepack-submit.php" method="POST">
                        <div class="form-group">
                            <label for="code" class="admin-panael">WelcomePack Code</label>
                            <input class="form-control" type="text" id="wp_code" name="wp_code" placeholder="WelcomePack Code" required>
                        </div>
                        <div class="form-group">
                            <label for="item" class="admin-panael">WelcomePack Name</label>
                            <input class="form-control" type="text" id="item" name="item" placeholder="Name" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Limit</label>
                            <input class="form-control" type="text" id="amount" name="amount" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Allocates(Item/Day)</label>
                            <input class="form-control" type="text" id="allocate" name="allocate" placeholder="Amount allocate (Item/Day)" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Couponlist</label>
                                <input type="hidden" name="coupon" value="0" />
                                <input type="checkbox" name="coupon" value="1">
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <input class="form-control" type="text" id="description" name="description" placeholder="Description" required />
                        </div>
                        <div class="form-group">
                            <label for="terms" class="admin-panael">Terms & conditions</label>
                            <textarea class="form-control" type="text" id="terms" name="terms" placeholder="Terms & conditions" rows="5" required / ></textarea>
                        </div>
                        <div class="form-group push-30-t">
                            <button class="btn btn-sm btn-block admin-panael btn-primary" type="submit">Create new</button>
                        </div>
                    </form>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../Cores/validation/validate_admin_redeem-add.js"></script>
<?php include '../Cores/template/footer_admin.php' ?>
