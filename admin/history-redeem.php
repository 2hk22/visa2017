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
                    mr.id member_redeem_id,
                    mr.timestamp recodetime
                FROM
                    `members_redeems` mr
                    INNER JOIN (
                        SELECT
                            id redeem_id,
                            item redeem_item,
                            merchant_code
                        FROM
                            `redeems`
                    ) r ON mr.redeem_id = r.redeem_id
                    INNER JOIN  (
                        SELECT
                            code merchant_code,
                            name merchant_nameS
                        FROM
                            `merchants`
                    ) m ON r.merchant_code = m.merchant_code
                ORDER BY
                    mr.timestamp';
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
            <h3 ><i class="fa fa-gift push-5-r text-left" style="font-size: 1.33em;"></i>Redeem History</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover js-dataTable-full dataTable no-footer display" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">CouponID</th>
                            <th class="text-center">Redeem</th>
                            <th class="text-center">Spending</th>
                            <th class="text-center">approval_code</th>
                            <th class="text-center">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($history as $h) { ?>
                            <tr>
                                <td class="text-center"><?php echo $h['member_redeem_id']; ?></td>
                                <td class="text-center"><?php echo $h['merchant_code'].'-'.$h['redeem_id']; echo$h['id']; ?></td>
                                <td class="text-center"><?php echo $h['redeem_item']; ?></td>
                                <td class="text-center"><?php echo $h['spending']; ?></td>
                                <td class="text-center"><?php echo $h['approval_code']; ?></td>
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
