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

        $sql = 'UPDATE `welcomepacks` SET
                        `code` = :code,
                        `name` = :name,
                        `limits` = :limits,
                        `allocate` = :allocate,
                        `term` = :term,
                        `description` = :description,
                        `coupon_list` = :coupon
                WHERE id LIKE :id ';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':code', $_POST['wp_code']);
        $stmt->bindParam(':name', $_POST['item']);
        $stmt->bindParam(':limits', $_POST['amount']);
        $stmt->bindParam(':allocate', $_POST['allocate']);
        $stmt->bindParam(':term', $_POST['terms']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':coupon', $_POST['coupon']);
        $stmt->execute();

        header('Location: welcomepack-list.php', true, 302);
        exit;
    }
?>
<?php include '../Cores/template/footer.php' ?>
