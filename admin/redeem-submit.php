<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header.php' ?>

<?php
    $db = Settings::database();
    if(empty($_SESSION['admin_id']))
    {
        header('Location: index.php', true, 302);
        exit;
    }
    else
    {
        $sql = 'INSERT INTO
                    `redeems`(
                        `item`, 
                        `description`, 
                        `amount`, 
                        `allocate`,
                        `allocate_now`,
                        `crireria`, 
                        `term`, 
                        `type`,
                        `merchant_code`
                    ) 
                VALUES (
                    :item,
                    :description,
                    :amount,
                    :allocate,
                    :allocate_now,
                    :crireria,
                    :term,
                    :type,
                    :merchant_code
                )';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':item', $_POST['item']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':amount', $_POST['amount']);
        $stmt->bindParam(':allocate', $_POST['allocate']);
        $stmt->bindParam(':allocate_now', $_POST['allocate']);
        $stmt->bindParam(':crireria', $_POST['crireria']);
        $stmt->bindParam(':term', $_POST['term']);
        $stmt->bindParam(':type', $_POST['type']);
        $stmt->bindParam(':merchant_code', $_POST['code']);
        $stmt->execute();

        header('Location: redeem-add.php', true, 302);
        exit;
    }
?>
<?php include '../Cores/template/footer.php' ?>
