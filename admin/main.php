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
                    `redeems` r
                    INNER JOIN `merchants` m
                WHERE r.merchant_code = m.code' ;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $redeems = $stmt->fetchAll();
    }

?>
<script>

</script>
<!-- Page Content -->
<div class="content content-boxed">
    <!-- Redeems -->
    <div class="block">
        <div class="block-header">
            <ul class="block-options">
                <li>
                    <a href="merchant-add.php">
                        <button type="button" style="background: none; border: none;">
                            <i class="fa fa-plus"></i> Add New Merchant
                        </button>
                    </a>
                </li>
                <li>
                    <a href="redeem-add.php">
                        <button type="button" style="background: none; border: none;">
                            <i class="fa fa-plus"></i> Add New Redeem
                        </button>
                    </a>
                </li>
            </ul>
            <h3 ><i class="fa fa-gift push-5-r" style="font-size: 1.33em;"></i>Gift List</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover js-dataTable-full dataTable no-footer display" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Zone</th>
                            <th class="text-center table-col-1">Gift<br>ID</th>
                            <th class="text-center table-col-2">Merchant<br>Name</th>
                            <th class="text-center table-col-3">Gift<br>Name</th>
                            <th class="text-center table-col-3 no-index">Description</th>
                            <th class="text-center table-col-1">Crireria</th>
                            <th class="text-center table-col-1">Item<br>Avilable</th>
                            <th class="text-center table-col-1">Allocate<br>(Limits/Day)</th>
                            <th class="text-center table-col-1">Allocate<br>now</th>
                            <th class="text-center table-col-5">Terms</th>
                            <th class="text-center table-col-1">Type</th>
                            <th class="text-center table-col-1">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($redeems as $r) { ?>
                            <tr>
                                <td class="text-center"><?php echo $r['country']; ?></td>
                                <td class="text-center"><?php echo $r['code'].'-'.$r['id'];?></td>
                                <td class="text-center"><?php echo $r['name']; ?></td>
                                <td class="text-center"><?php echo $r['item']; ?></td>
                                <td class="text-center">
                                    <div class="term-container">
                                        <?php echo $r['description']; ?>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo $r['crireria']; ?></td>
                                <td class="text-center <?php if($r['amount'] <3)echo"red";?>"><?php echo $r['amount']; ?></td>
                                <td class="text-center"><?php echo $r['allocate']; ?></td>
                                <td class="text-center <?php if($r['allocate_now'] <1)echo"red";?>"><?php echo $r['allocate_now']; ?></td>
                                <td class="text-left">
                                    <div class="term-container">
                                         <?php echo $r['term']; ?>
                                    </div>
                                </td>
                                <td class="text-center"><?php if($r['type'] == 'cash') {echo 'Voucher';}else{echo 'Gift';} ?></td>
                                <td class="text-right">
                                    <a href="<?php echo Settings::full_path()."admin/redeem-add.php?edit_id=".$r['id']?>">
                                        <button class="btn btn-xs btn-default" type="button">
                                            <i class="fa fa-pencil text-success"></i>Edit
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Redeems -->
</div>
<!-- END Page Content -->
<?php include '../Cores/template/footer_admin.php' ?>
