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
    <title>Orders</title>
</head>

<body>
    <?php

    require_once('../partials/header.php');

    if (isset($_GET['info'])) {
        echo <<< INFO
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="text-center">
        $_GET[info]
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    INFO;
    }

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
                    <p class="card-text text-muted mb-2" style="font-size: 13px">Your order history is clear. Place your order through our menu.</p>
                </div>
        </div>';
    } else {
        echo "<table class='table table-sm table-striped table-bordered'>
        <thead>
            <tr>
                <th scope='col'><img src='../img/calendar-date.svg' alt='' class='filter-brown'> Date</th>
                <th scope='col'><img src='../img/body-text.svg' alt='' class='filter-brown'> Description</th>
                <th scope='col'><img src='../img/gear-fill.svg' alt='' class='filter-brown'> Actions</th>
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
            $date = strtotime($order['date']);
            $newDate = date('D-d-M', $date);
            echo <<< ORDERS
                    <tr>
                    <td><p>$newDate</p></td>
                    <td><p>$order[description]</p></td>
                    <td><img src='../img/bag-x-fill.svg' alt=''class='filter-brown'><a href='../scripts/cancel_order.php?cancelOrderId=$order[id]&date=$newDate' style='text-decoration: none;font-weight: normal;color: #947361;'> Cancel</a></td></td>
                    </tr>
                ORDERS;
        }
        echo "</tbody>
    </table>";
    }
    ?>

</body>

</html>