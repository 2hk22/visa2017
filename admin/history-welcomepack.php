<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_admin.php' ?>

<?php
    $db = Settings::database();
    if(empty($_SESSION['admin_id']))
    {
        echo '<script> location.replace("index.php"); </script>';
    }
    else
    {
        $sql = 'SELECT
                    *,
                    wr.timestamp recodetime,wr.id
                FROM
                    `welcomepacks_registers` wr
                    INNER JOIN `welcomepacks` w ON wr.welcomepack_id = w.id
                ORDER BY
                    wr.timestamp';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $history = $stmt->fetchAll();
        //var_dump($history);
    }
?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- Redeems -->
    <div class="block">
        <div class="block-header">
            <h3 ><i class="fa fa-users push-5-r text-left"></i>WelcomePack List</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover js-dataTable-full dataTable no-footer display" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">id</th>
                            <th class="text-center">Coupon ID</th>
                            <th class="text-center">WelcomePack<br>Name</th>
                            <th class="text-center">Region</th>
                            <th class="text-center">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($history as $h) { ?>
                            <tr>
                                <td class="text-center"><?php echo $h['id']; ?></td>
                                <td class="text-center"><?php echo $h['code'].'-'.$h['welcomepack_id'].$h['id']; ?></td>
                                <td class="text-center"><?php echo $h['name']; ?></td>
                                <td class="text-center"><?php echo $h['country']; ?></td>
                                <td class="text-center"><?php echo $h['recodetime']; ?></td>
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
