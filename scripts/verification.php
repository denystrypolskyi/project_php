<?php
session_start();

require_once("conn_db.php");

if (isset($_GET['code'])) {
    $stmt = $conn->prepare("SELECT `verification_code`, `email_verified_at` FROM `users` WHERE `verification_code`=?");
    $stmt->bind_param("s", $_GET['code']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($verification_code, $email_verified_at);
    $stmt->fetch();

    $numRows = $stmt->num_rows;

    $now = date_create()->format('Y-m-d H:i:s');

    if ($numRows > 0) {
        if (is_null($email_verified_at)) {
            $stmt = $conn->prepare("UPDATE `users` SET `email_verified_at`=? WHERE `verification_code`=?");
            $stmt->bind_param('ss', $now, $_GET['code']);
            $stmt->execute();

            $stmt = $conn->prepare("SELECT `email_verified_at` FROM `users` WHERE  `verification_code`=?");
            $stmt->bind_param('s', $_GET['code']);
            $stmt->execute();
            $stmt->bind_result($_SESSION['email_verified_at']);
            $stmt->fetch();

            if (!is_null($_SESSION['email_verified_at'])) {
                //echo "Congratulations! Your account was verified!";
                header("Location: ../pages/home.php");
            } else {
                echo "Verification failed!";
            }
        } else {
            echo "Your account is already verified!";
        }
    } else {
        echo "Verification code not found!";
    }
}
