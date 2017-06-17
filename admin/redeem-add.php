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
        $sql = 'SELECT
                    *
                FROM
                    `merchants` ORDER BY `country`';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $mr = $stmt->fetchAll();


        if (!empty($_GET['edit_id'])) {

            $sql = 'SELECT
                    *
                    FROM
                        `redeems`
                    WHERE
                        id LIKE :id  ';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_GET['edit_id']);
            $stmt->execute();
            $re = $stmt->fetch();
            //var_dump($re);

       }//.edit
    }
?>

<div class="content content-boxed">
    <div class="block">
        <div class="block-header">
            <h4><i class="fa fa-gift push-5-r" style="font-size: 1.33em;"></i>Gift List &nbsp; | &nbsp;
            <?php if (empty($_GET['edit_id'])) { ?>
            <i class="fa fa-plus"></i> Add New Gift
            <?php }else{ ?>
            <i class="fa fa-pencil"></i> Edit Gift : <?php echo $re['item'] ?>
            <?php } ?>
            </h4>
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 admin-panael">.
<?php if (empty($_GET['edit_id'])) { ?>
                    <form class="form-horizontal push-10-t" id="validate_admin_redeem-add" action="redeem-submit.php" method="POST">
                        <div class="form-group">
                            <label for="code" class="admin-panael">Merchant</label>
                            <select class="form-control" id="code" name="code" required>
                            <option value="">Select Merchant</option>
                            <?php foreach($mr as $mr) { ?>
                                <option value="<?php echo  $mr['code'] ?>"><?php echo $mr["code"]." - ".$mr["name"]." - ".$mr["country"]?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item" class="admin-panael">Gift Name</label>
                            <input class="form-control" type="text" id="item" name="item" placeholder="Name" required />
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <textarea class="form-control" type="text" id="description" name="description" placeholder="Description" rows="5" required / ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Item Available</label>
                            <input class="form-control" type="text" id="amount" name="amount" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Allocate(Limit Item Per Days/Every 00:00)</label>
                            <input class="form-control" type="text" id="allocate" name="allocate" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="crireria" class="admin-panael">Crireria</label>
                            <input class="form-control" type="text" id="crireria" name="crireria" placeholder="Need More ?" required />
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <textarea class="form-control" type="text" id="term" name="term" placeholder="Pls.input term in Format : <li>....</li>" rows="5" required / ><li>Customer must present Visa sales slip with qualified purchase amount</li><li>The offer can be redeemed at the merchant outlet where the QR code was scanned only</li><li>The offer is valid from 15 June – 31 August 2017</li><li>The offer cannot be redeemed or exchanged for cash</li><li>Terms and conditions apply for usage of each offer</li>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="type" class="admin-panael">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Gift Type</option>
                                <option value="cash">Voucher</option>
                                <option value="gift">Gift</option>
                            </select>
                        </div>
                        <div class="form-group push-30-t">
                            <button class="btn btn-sm btn-block admin-panael btn-primary" type="submit">Create new</button>
                        </div>
                    </form>
<?php }else{ ?>
                    <form class="form-horizontal push-10-t" id="validate_admin_redeem-add" action="redeem-edit.php" method="POST">
                        <div class="form-group">
                            <label for="code" class="admin-panael">Merchant</label>
                            <select class="form-control" id="code" name="code" required>
                            <option value="">Select Merchant</option>
                            <option value="">test</option>
                            <?php foreach($mr as $mr) { ?>
                                <option value="<?php echo  $mr['code'] ?>"
                                <?php if ($re['merchant_code'] == $mr['code']){echo 'selected="selected"';}?>>
                                <?php echo $mr["code"]." - ".$mr["name"]." - ".$mr["country"]?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item" class="admin-panael">Gift Name</label>
                            <input class="form-control" value="<?php echo $re['item'] ?>" type="text" id="item" name="item" placeholder="Name" required />
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <textarea class="form-control" type="text" id="description" name="description" placeholder="Description" rows="5" required / ><?php echo $re['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Item Available</label>
                            <input class="form-control" value="<?php echo $re['amount'] ?>" type="text" id="amount" name="amount" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="amount" class="admin-panael">Allocate(Limit Item Per Days/Every 00:00)</label>
                            <input class="form-control" value="<?php echo $re['allocate'] ?>" type="text" id="allocate" name="allocate" placeholder="Amount" required />
                        </div>
                        <div class="form-group">
                            <label for="crireria" class="admin-panael">Crireria</label>
                            <input class="form-control" value="<?php echo $re['crireria'] ?>" type="text" id="crireria" name="crireria" placeholder="Need More ?" required />
                        </div>
                        <div class="form-group">
                            <label for="description" class="admin-panael">Description</label>
                            <textarea class="form-control" type="text" id="term" name="term" placeholder="Pls.input term in Format : <li>....</li>" rows="5" required / ><?php echo $re['term']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type" class="admin-panael">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Gift Type</option>
                                <option value="cash"<?php if ($re['type'] == 'cash'){echo 'selected="selected"';}?>>Voucher</option>
                                <option value="gift"<?php if ($re['type'] == 'gift'){echo 'selected="selected"';}?>>Gift</option>
                            </select>
                        </div>
                        <div class="form-group visiblity-none">
                            <label for="" class="admin-panael">id</label>
                            <input class="form-control" value="<?php echo $re['id'] ?>" type="text" id="id" name="id" placeholder="Name" required />
                        </div>
                        <div class="form-group push-30-t">
                            <button class="btn btn-sm btn-block admin-panael btn-primary" type="submit">Edit Gift</button>
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
