<?php
require_once("../scripts/conn_db.php");

require_once("../scripts/authentication.php");

if (is_null($_SESSION['email_verified_at'])) {
    header("Location: ./home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order History</title>
    <style>
        .card {
            padding: 10px;
        }
    </style>
</head>

<body>
    <?php

    require_once('../partials/header.php');

    $sql = "SELECT * FROM `orders` WHERE `user_id` = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo '<div class="card" style="width:225px;">
            <div class="card-body">
                <img class="card-img" src="../img/no-orders.png" alt="">
            </div>
            <div class="text-center">
                    <p class="card-text text-muted" style="font-size: 13px">Your order history is clear. Place your order through our menu.</p>
                </div>
        </div>';
    } else {
        echo "<table class='table table-sm table-striped table-bordered'>
        <thead>
            <tr>
                <th scope='col'><img src='../img/list-ol.svg' alt='' class='filter-brown'> Id</th>
                <th scope='col'><img src='../img/calendar-date.svg' alt='' class='filter-brown'> Date</th>
                <th scope='col'><img src='../img/body-text.svg' alt='' class='filter-brown'> Description</th>
            </tr>
        </thead>
        <tbody>";

        $sql = 'SELECT `id`, `date`, `description` from orders where `user_id`=?';
        $stmt = $conn->prepare($sql);
        $id = $_SESSION['id'];
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($order = $result->fetch_assoc()) {
            echo <<< ORDERS
                    <tr>
                    <th scope='row'><p>$order[id]</p></th>
                    <td><p>$order[date]</p></td>
                    <td><p>$order[description]</p></td>
                    </tr>
                ORDERS;
        }
        echo "</tbody>
    </table>";
    }
    ?>

</body>

</html>

<!-- echo <<< PROFILE
        <div class="card" style="height: 100%">
            <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <img src="../img/card-text.svg" alt="" class="filter-brown">
                        <span>$_SESSION[name]</span>
                    </li>
                    <li class="list-group-item">
                        <img src="../img/envelope-fill.svg" alt="" class="filter-brown">
                        <span>$_SESSION[email]</span>
                    </li>
        PROFILE;
    if ($_SESSION['role'] === 'Administrator') {
        echo '<li class="list-group-item">
            <img src="../img/person-fill-gear.svg" alt="" class="filter-brown">
            <span>Administrator</span>
        </li>';
    } else {
        echo '<li class="list-group-item">
            <img src="../img/person-fill.svg" alt="" class="filter-brown">
            <span>Student</span>
        </li>';
    }
    echo '</ul>
        </div>'; -->