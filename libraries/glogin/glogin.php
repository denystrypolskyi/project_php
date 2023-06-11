<?php
session_start();

require_once 'vendor/autoload.php';

if (isset($_GET['code'])) {
    require_once("../../scripts/conn_db.php");
} else {
    require_once("../scripts/conn_db.php");
}
// init configuration 
$clientID = '703067507201-rn0k0pa0hivia04h17dggljl4qoavnmf.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/Project_PHP/libraries/glogin/glogin.php';

// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow 
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info 
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    $stmt = $conn->prepare("SELECT `id`, `name`, `password`, `email`, `role`, `email_verified_at` FROM `users` WHERE `email`=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    $numRows = $stmt->num_rows;

    if ($numRows > 0) {
        $stmt->bind_result($id, $name, $password, $email, $role, $email_verified_at);
        $stmt->fetch();

        $_SESSION['auth'] = "Authenticated";
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['email_verified_at'] = $email_verified_at;

        header("Location: ../../pages/home.php");
    } else {
        $now = date_create()->format('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO `users` (`name`, `email`, `email_verified_at`) VALUES (?,?,?);");
        $stmt->bind_param("sss", $name, $email, $now);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT `id`, `name`, `password`, `email`, `role`, `email_verified_at` FROM `users` WHERE `email`=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $name, $password, $email, $role, $email_verified_at);
        $stmt->fetch();

        $_SESSION['auth'] = "Authenticated";
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['email_verified_at'] = $email_verified_at;
        header("Location: ../../pages/home.php");
    }
}
