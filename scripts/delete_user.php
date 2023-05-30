<?php
require_once("../scripts/authentication.php");

require_once("../scripts/conn_db.php");

if (isset($_GET['deleteUserId'])) {

    if ($_GET['deleteUserId'] == $_SESSION['id']) {
        header("Location: ../pages/control_panel.php?error=You can't delete your own account.");
        exit();
    }
    $sql = "DELETE FROM `users` WHERE `users`.`id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['deleteUserId']);
    $stmt->execute();
    echo '<script>history.back()</script>';
}
