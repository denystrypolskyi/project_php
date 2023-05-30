<?php
require_once("../scripts/authentication.php");

require_once("../scripts/conn_db.php");


$date = $_POST['date'];
$id = $_SESSION['id'];

$sql = "SELECT * FROM `orders` WHERE `date` = ? AND `user_id` = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("si", $date, $id);
$stmt->execute();

$stmt->store_result();

if ($stmt->num_rows == 0) {
    $description = "";

    foreach ($_SESSION['list'] as $food => $quantity) {

        $description = "$description $food ($quantity) ";
    }

    $stmt = $conn->prepare("SELECT * FROM `orders`");

    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $sql = "ALTER TABLE `orders` AUTO_INCREMENT = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    $sql = "INSERT INTO `orders` (`id`, `user_id`, `date`, `description`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $null = null;

    $stmt->bind_param("iiss", $null, $id, $date, $description);
    $stmt->execute();

    unset($_SESSION["list"]);

    header("Location: ../pages/menu.php?info=You have successfully ordered food.");
} else {
    header("Location: ../pages/menu.php?error=You have already ordered food that day. Please select another date.");
}
