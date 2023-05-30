<?php
session_start();

require_once("conn_db.php");

use PHPMailer\PHPMailer\PHPMailer;

require '../libraries/phpmailer/src/Exception.php';
require '../libraries/phpmailer/src/PHPMailer.php';
require '../libraries/phpmailer/src/SMTP.php';

if (isset($_POST['uName']) && isset($_POST['uEmail']) && isset($_POST['uPassword']) && isset($_POST['uPassword2'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uName = validate($_POST['uName']);
    $uEmail = validate($_POST['uEmail']);
    $uEmail2 = validate($_POST['uEmail2']);
    $uPassword = validate($_POST['uPassword']);
    $uPassword2 = validate($_POST['uPassword2']);

    if (!empty($uName) && !empty($uEmail) && !empty($uEmail2) && !empty($uPassword) && !empty($uPassword2)) {
        if ($uPassword != $uPassword2) {
            header("Location: ../pages/register.php?error=Passwords do not match.");
            exit();
        } else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])\S{8,}$/', $uPassword)) {
            header("Location: ../pages/register.php?error=Your password does not meet the requirements.");
            exit();
        }

        if ($uEmail != $uEmail2) {
            header("Location: ../pages/register.php?error=Email addresses do not match.");
            exit();
        }

        $sql = "SELECT email FROM `users` WHERE email='$uEmail'";
        mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) == 1) {
            header("Location: ../pages/register.php?error=Email already exists.");
            exit();
        }

        $sql = "SELECT name FROM `users` WHERE name='$uName'";
        mysqli_query($conn, $sql);
        if (mysqli_affected_rows($conn) == 1) {
            header("Location: ../pages/register.php?error=Name already exists.");
            exit();
        }

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'energyneverdiesright@gmail.com';
        $mail->Password = 'nhydrltgjsuwhyxq';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('dennistripolskiy@gmail.com'); // sender

        $mail->addAddress($uEmail); // receiver

        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $mail->Subject = 'Email Verification';
        $mail->Body = '<p>Click on the "Click here to activate" link to activate your account: <a href="http://localhost/Project_PHP/scripts/verification.php?code=' . $verification_code . '">Click here to activate</a></p>';
        $now = date_create()->format('Y-m-d H:i:s');

        $mail->send();

        echo "<script>alert('Sent Successfully');</script>";

        $pass = password_hash($uPassword, PASSWORD_ARGON2ID);

        $stmt = $conn->prepare("INSERT INTO `users` (`name`, `password`, `email`, `verification_code`) VALUES (?, ?, ?, ?);");
        $stmt->bind_param('ssss', $uName, $pass, $uEmail, $verification_code);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            $stmt = $conn->prepare("SELECT `id`, `name`, `password`, `email`, `role`, `email_verified_at` FROM `users` WHERE `email`=?");
            $stmt->bind_param("s", $uEmail);
            $stmt->execute();

            $stmt->bind_result($id, $name, $password, $email, $role, $email_verified_at);
            $stmt->fetch();

            $_SESSION['auth'] = "Authenticated";
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['email_verified_at'] = $email_verified_at;
            header("location: ../pages/home.php");
            exit();
        } else {
            header("Location: ../pages/register.php?error=Unknown error.");
            exit();
        }
    } else {
        header("Location: ../pages/register.php?error=Please fill out all required fields.");
        exit();
    }
}
