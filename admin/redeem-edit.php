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

        $sql = 'UPDATE `redeems` SET
                        `item`= :item,
                        `description`= :description,
                        `amount`= :amount,
                        `allocate`= :allocate,
                        `crireria`= :crireria,
                        `term`= :term,
                        `type`= :type,
                        `merchant_code`= :merchant_code
                WHERE id LIKE :id ';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':item', $_POST['item']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':amount', $_POST['amount']);
        $stmt->bindParam(':allocate', $_POST['allocate']);
        $stmt->bindParam(':crireria', $_POST['crireria']);
        $stmt->bindParam(':term', $_POST['term']);
        $stmt->bindParam(':type', $_POST['type']);
        $stmt->bindParam(':merchant_code', $_POST['code']);
        $stmt->execute();

        header('Location: main.php', true, 302);
        exit;
    }
?>
<?php include '../Cores/template/footer.php' ?>
