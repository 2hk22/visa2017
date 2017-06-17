<?php include '../Cores/Settings.php'; ?>
<?php include '../Cores/template/header.php'?>

<?php
    $db = Settings::database();
    if(empty($_SESSION['admin_id']))
    {
        header('Location:index.php', true, 302);
        exit;
    }
    else
    {
        $sql = 'INSERT INTO
                    `merchants`(
                        `code`,
                        `name`,
                        `country`
                    )
                VALUES (
                    :code,
                    :name,
                    :country
                )';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':code', $_POST['code']);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':country', $_POST['country']);
        $stmt->execute();

        header('Location: merchant-add.php', true, 302);
        exit;
    }
?>
<?php include '../Cores/template/footer.php' ?>
