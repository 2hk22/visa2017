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
                    `welcomepacks`(
                        `code`,
                        `name`,
                        `limits`,
                        `allocate`,
                        `allocate_now`,
                        `term`,
                        `description`
                    )
                VALUES (
                        :wp_code,
                        :item,
                        :amount,
                        :allocate,
                        :allocate_now,
                        :terms,
                        :description
                )';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':wp_code', $_POST['wp_code']);
        $stmt->bindParam(':item', $_POST['item']);
        $stmt->bindParam(':amount', $_POST['amount']);
        $stmt->bindParam(':allocate', $_POST['allocate']);
        $stmt->bindParam(':allocate_now', $_POST['allocate']);
        $stmt->bindParam(':terms', $_POST['terms']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->execute();

        header('Location: welcomepack-add.php', true, 302);
        exit;
    }
?>
<?php include '../Cores/template/footer.php' ?>
