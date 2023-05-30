<?php
require_once("../scripts/conn_db.php");

require_once("../scripts/authentication.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
</head>

<body>
    <?php
    require_once('../partials/header.php');
    ?>
    <?php
    if (is_null($_SESSION['email_verified_at'])) {
        echo '<div class="alert alert-warning " role="alert">
            <strong>Limited access!</strong> Please check your inbox to verify your account.
            </div>';
    } else {
        echo "<p>Hi, $_SESSION[name]</p>";
    }
    ?>
</body>

</html>