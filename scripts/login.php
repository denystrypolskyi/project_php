<?php
session_start();

require_once("conn_db.php");

if (isset($_POST['uEmail']) && isset($_POST['uPassword'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uEmail = validate($_POST['uEmail']);
    $uPassword = validate($_POST['uPassword']);
}
if (empty($uEmail)) {
    header("Location: ../pages/login.php?error=Email is required.");
    exit();
} else if (empty($uPassword)) {
    header("Location: ../pages/login.php?error=Password is required.");
    exit();
}

$stmt = $conn->prepare("SELECT `id`, `name`, `password`, `email`, `role`, `email_verified_at` FROM `users` WHERE `email`=?");
$stmt->bind_param("s", $uEmail);
$stmt->execute();
$stmt->store_result();

$numRows = $stmt->num_rows;

$stmt->bind_result($id, $name, $password, $email, $role, $email_verified_at);
$stmt->fetch();

if ($numRows > 0) {
    if (password_verify($uPassword, $password)) {
        $_SESSION['auth'] = "Authenticated";
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['email_verified_at'] = $email_verified_at;
        header("Location: ../pages/home.php");
        exit();
    } else {
        header("Location: ../pages/login.php?error=Incorrect password.");
        exit();
    }
} else {
    header("Location: ../pages/login.php?error=Incorrect email.");
    exit();
}
