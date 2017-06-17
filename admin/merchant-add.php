<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header_admin.php' ?>

<?php
    $db = Settings::database();
    if(empty($_SESSION['admin_id']))
    {
        header('Location: index.php', true, 302);
        exit;
    }
?>

 <div class="content content-boxed">
    <div class="block">
        <div class="block-header">
            <h4><i class="fa fa-gift push-5-r" style="font-size: 1.33em;"></i>Gift List &nbsp; | &nbsp;<i class="fa fa-plus"></i> Add New Merchants</h4>
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 admin-panael">
                    <form class="form-horizontal push-30-t" id="admin_merchant-add" action="merchant-submit.php" method="POST">
                        <div class="form-group">
                            <label for="code" class="admin-panael">Merchant Code</label>
                            <input class="form-control" type="text" id="code" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="item" class="admin-panael">Merchant Name</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="type" class="admin-panael">Merchant Zone</label>
                            <select class="form-control" id="country" name="country" required>
                                <option value="">Select Merchant Zone</option>
                                <option value="BKK">Bangkok</option>
                                <option value="CMI">Chiangmai</option>
                                <option value="CBI">Chonburi</option>
                                <option value="PKT">Phuket</option>
                            </select>
                        </div>
                        <div class="form-group push-30-t">
                                <button class="btn btn-sm btn-block admin-panael btn-primary" type="submit">Create new</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../Cores/validation/validate_admin_merchant-add.js"></script>
<?php include '../Cores/template/footer_admin.php' ?>

