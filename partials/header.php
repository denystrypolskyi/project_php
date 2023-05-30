<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            font-family: "Poppins", sans-serif;
            color: #947361;
            font-weight: bold;
        }

        body {
            background: #f8f8f8;
            color: #947361;
            font-weight: bold;
            padding-left: 100px;
            padding-right: 100px;
        }

        .nav-link {
            color: #947361;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #50a684;
        }

        h4 {
            font-weight: bold;
        }

        h5 {
            font-weight: bold;
        }

        p {
            font-weight: normal;
            font-size: 16px;
        }

        .card {
            color: #947361;
        }

        .btn-sm {
            border-radius: 25px;
        }

        .filter-brown {
            filter: invert(49%) sepia(8%) saturate(1307%) hue-rotate(337deg) brightness(95%) contrast(99%);
        }

        .filter-silver {
            filter: invert(56%) sepia(11%) saturate(392%) hue-rotate(155deg) brightness(98%) contrast(92%);
        }

        .table-bordered {
            border-color: #947361 !important;
        }
    </style>
</head>
<?php
include "../scripts/conn_db.php";
if (isset($_SESSION['auth'])) {
    echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <img src="../../favicon.ico" alt="" class="navbar-brand" style="width:40px;">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./home.php">Home</a>
            </li>';
    if (!is_null($_SESSION['email_verified_at'])) {
        echo '<li class="nav-item">
                    <a class="nav-link" href="./menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./orders.php">Orders</a>
                </li>';
    } else {
        echo '<li class="nav-item">
            <a class="nav-link disabled" href="./menu.php">Menu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="./orders.php">Orders</a>
        </li>';
    }
    if ($_SESSION['role'] === 'Administrator') {
        echo '<li class="nav-item">
        <a class="nav-link" href="./control_panel.php">Control Panel</a>
    </li>';
    }
    echo "</ul><ul class='navbar-nav ms-auto'>
    <li class='nav-item'>
    <a class='nav-link' href='#' style='font-weight: normal'>$_SESSION[email]</a>
    </li>
    <li class='nav-item'>
    <a class='nav-link' href='../scripts/logout.php'>Logout</a>
    </li></nav>";
}
