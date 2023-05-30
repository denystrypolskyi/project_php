<?php

session_start();

include "conn_db.php";

use PHPMailer\PHPMailer\PHPMailer;

require '../libraries/phpmailer/src/Exception.php';
require '../libraries/phpmailer/src/PHPMailer.php';
require '../libraries/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'energyneverdiesright@gmail.com';
$mail->Password = 'nhydrltgjsuwhyxq';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('dennistripolskiy@gmail.com'); // sender

$mail->addAddress("energyneverdiesright@gmail.com"); // receiver

$mail->isHTML(true);

$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

$mail->Subject = 'Email Verification';
$mail->Body = '<p>Click on the "Click here to activate" link to activate your account: <a href="http://localhost/Project_PHP/scripts/verification.php?code=" . $verification_code. ">Click here to activate</a></p>';
$now = date_create()->format('Y-m-d H:i:s');

$mail->send();

echo "<script>alert('Sent Successfully');</script>";

//$sql = "INSERT INTO `users`(`username`, `password`, `email`, `verification_code`,`email_verified_at`) VALUES ('debiltest','debiltest','debiltest@gmail.com','123', '$now')";

//$sql = "INSERT INTO `users`(`username`, `password`, `email`, `verification_code`) VALUES ('debiltest','debiltest','debiltest@gmail.com','$verification_code')";

// $conn->query($sql);
