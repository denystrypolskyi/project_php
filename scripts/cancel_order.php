<?php
require_once("../scripts/authentication.php");

require_once("../scripts/conn_db.php");

if (isset($_GET['cancelOrderId'])) {
    $sql = "DELETE FROM `orders` WHERE `orders`.`id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['cancelOrderId']);
    $stmt->execute();
    header("Location: ../pages/orders.php?info=Your order for $_GET[date] has been cancelled.");
    exit();
}
