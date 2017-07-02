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
                    `welcomepacks`';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $h = $stmt->fetchAll();
        //var_dump($h);
    }

?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- Redeems -->
    <div class="block">
        <div class="block-header">
            <ul class="block-options">
                <li>
                    <a href="welcomepack-add.php">
                        <button type="button" style="background: none; border: none;">
                            <i class="fa fa-plus"></i> Add New Welcome Pack
                        </button>
                    </a>
                </li>
            </ul>
            <h3 ><i class="fa fa-users push-5-r"></i>WelcomePack List</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover js-dataTable-full dataTable no-footer display" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center table-col-1">id</th>
                            <th class="text-center table-col-1">w ID</th>
                            <th class="text-center table-col-5">WelcomePack Name</th>
                            <th class="text-center table-col-1">Limits</th>
                            <th class="text-center table-col-1">Allocate<br>(Item/Day)</th>
                            <th class="text-center table-col-1">Allocate<br>Now</th>
                            <th class="text-center table-col-5">Terms</th>
                            <th class="text-center table-col-1">Coupon List</th>
                            <th class="text-center table-col-1">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($h as $h) { ?>
                            <tr>
                                <td class="text-center"><?php echo $h['id']; ?></td>
                                <td class="text-center"><?php echo $h['code'].'-'.$h['id']; ?></td>
                                <td class="text-center"><?php echo $h['name']; ?></td>
                                <td class="text-center <?php if($h['limits'] <20)echo"red";?>"><?php echo $h['limits']; ?></td>
                                <td class="text-center"><?php echo $h['allocate']; ?></td>
                                <td class="text-center <?php if($h['allocate_now'] <5)echo"red";?>"><?php echo $h['allocate_now']; ?></td>
                                <td class="text-left">
                                    <div class="term-container">
                                         <?php echo $h['term']; ?>
                                    </div>
                                </td>
                                <td class="text-right">
                                <?php if ($h['coupon_list'] == 1){ ?>
                                    <a href="<?php echo Settings::full_path()."admin/welcomepack-coupon.php?w_id=".$h['id']?>">
                                        <button class="btn btn-xs btn-default" type="button">
                                            <i class="fa fa-ticket text-warning"></i> Add
                                        </button>
                                    </a>
                                <?php } ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?php echo Settings::full_path()."admin/welcomepack-add.php?edit_id=".$h['id']?>">
                                        <button class="btn btn-xs btn-default" type="button">
                                            <i class="fa fa-pencil text-success"></i> Edit
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
