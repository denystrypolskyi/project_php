<?php
require_once("../libraries/glogin/glogin.php");

if (isset($_SESSION['auth'])) {
    header("Location: ./home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <?php
    if (isset($_GET['error'])) {
        echo <<< ERRORS
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%; margin-left:auto;margin-right:auto; top: 15px;">
        <div class="text-center">
        $_GET[error]
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ERRORS;
    }
    ?>

    <div class="container" style="margin-top:30px; margin-bottom:25px;">
        <input type="checkbox" id="check" checked>
        <div class="registration form">
            <header>Register</header>
            <form action="../scripts/register.php" method="post">
                <input type="email" placeholder="Enter your email" name="uEmail" autocomplete="off" required>
                <input type="email" placeholder="Confirm your email" name="uEmail2" autocomplete="off" required>
                <input type="text" placeholder="Enter your name" name="uName" autocomplete="off" required />
                <input type="password" placeholder="Enter your password" name="uPassword" autocomplete="off" required>
                <input type="password" placeholder="Confirm your password" name="uPassword2" autocomplete="off" required>
                <input type="submit" class="button" value="Register">
            </form>
            <?php
            echo "<p class='text-center'>Register with ";
            echo "<a href='" . $client->createAuthUrl() . "'>Google</a>";
            echo "</p>";
            ?>
            <div class="signup">
                <span class="signup">Already have an account?
                    <a href="./login.php">Login</a>
                </span>
            </div>
        </div>
    </div>
</body>

</html>