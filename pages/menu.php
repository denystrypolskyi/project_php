<?php
require_once("../scripts/authentication.php");

if (is_null($_SESSION['email_verified_at'])) {
    header("Location: ./home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Menu</title>
    <style>
        .card {
            width: 140px;
            padding: 10px;
        }

        .m-l {
            margin-left: 40px;
        }

        .m-b {
            margin-bottom: 20px;
        }

        .m-t {
            margin-top: 20px;
        }

        .list-group-item {
            font-size: 13px;
        }

        .image {
            padding: 10px;
        }

        p {
            font-size: 13px !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(49%) sepia(8%) saturate(1307%) hue-rotate(337deg) brightness(95%) contrast(99%);
        }
    </style>
</head>

<body>
    <?php
    require_once('../partials/header.php');

    if (isset($_GET['error'])) {
        echo <<< ERRORS
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="text-center">
        $_GET[error]
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ERRORS;
    } else if (isset($_GET['info'])) {
        echo <<< INFO
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="text-center">
        $_GET[info]
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    INFO;
    }

    if (isset($_SESSION["list"])) {
        $list = $_SESSION["list"];
    } else {
        $list = array();
    }

    if (isset($_GET["item"])) {
        if (!isset($list[$_GET["item"]])) {
            $list[$_GET["item"]] = 1;
        } else {
            $list[$_GET["item"]] += 1;
        }

        $_SESSION["list"] = $list;
        header("location: ./menu.php");
    } else if (isset($_GET["removeItem"])) {
        if ($list[$_GET["removeItem"]] - 1 == 0) {
            unset($list[$_GET["removeItem"]]);
        } else {
            $list[$_GET["removeItem"]] -= 1;
        }
        $_SESSION["list"] = $list;
        header("location: ./menu.php");
    }

    if (isset($list)) {
        if (count($list) > 0) {
            echo '<div class="card" style="width:225px; ">';
            echo '<div class="card-body">';
            $total_quantity = 0;
            foreach ($list as $key => $value) {
                $total_quantity += $value;
            }

            echo <<< CART
            <span style='top:20px;left:12.5px; position: absolute;font-weight: bold;font-size:20px; color:#947361'>Cart ($total_quantity)</span>
            <a href='../scripts/clear_cart.php' style='top:28.5px;right:12.5px; position: absolute;font-weight: normal;font-size:13px; text-decoration:none;color:#50a684'>Clear</a>
            </div>
            <ul class="list-group list-group-flush" style="width:200px; margin-top:20px;">
        CART;
            foreach ($list as $key => $value) {
                echo <<< CART
                <li class="list-group-item">
                <img src="../img/$key.png" alt="" style="width:30px; margin-right:10px; padding-right:10px;">
                <strong>$key</strong>
                <a href="./menu.php?removeItem=$key" class="float-end" style="font-size:15px; text-decoration:none; margin-left: 5px;">
                <strong style="color: #50a684;">-</strong>
                </a>
                <strong class="float-end" style="font-size:15px; text-decoration:none; margin-left:5px;"">$value</strong>
                <a href="./menu.php?item=$key" class="float-end" style="font-size:15px; text-decoration:none;">
                <strong style="color: #50a684;">+</strong>
                </a>
                </li>
        CART;
            }
            echo "</ul>";
            $dateNow = date("Y-m-d");
            echo <<< CART
                <form action='../scripts/order_food.php' method='post'>
                <div class='input-group mt-3'>
                    <input type='date' class='form-control' style='color: #947361; height:30px; ' value='$dateNow' name='date'>
                </div>
                <button type='submit' class='btn btn-sm btn-success' style='width:100%; margin-top:12px;'>Order</button>
                </form>
                CART;
            echo '</div>';
        } else {
            echo <<< EMPTYCART
                    <div class="card" style="width:225px;">
                    <div class="card-body">
                        <h5 class='card-title' style="text-align:center;">Cart is empty<span data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
                                <img src="../img/caret-down-fill.svg" alt="" class="filter-brown">
                            </span></h5>
                        <div class="collapse" id="collapseExample">
                            <div class="text-center">
                                <img class="card-img" src="../img/Cart.png" alt="">
                                <p class="card-text" style="margin-top:15px;">Your cart is empty. Add items from the menu.</p>
                            </div>
                        </div>
                    </div>
                </div>
                EMPTYCART;
        }
    }
    ?>

    <h4 class="m-t"><img src='../img/steak.png' alt='' style="width:32px;"> Food</h4>
    <div class="row">
        <?php
        $food = ["Spaghetti", "Hamburger", "Sandwich", "Bacon", "Pizza", "Hot Dog", "Fried Egg", "Taco", "Fries"];

        foreach ($food as $value) {
            if ($value == "Spaghetti") {
                echo "<div class='col-1'>";
            } else {
                echo "<div class='col-1 m-l'>";
            }
            echo "<div class='card'><img src='../img/$value.png' alt='' class='image'>
            <div class='text-center'>
                <div class='card-title'>$value</div>
            </div>
            <a href='./menu.php?item=$value' class='btn btn-sm btn-success'>Add</a>
        </div>
    </div>";
        }
        ?>
    </div>

    <h4 class="m-t"><img src='../img/Fruits.png' alt='' style="width:32px;"> Fruits</h4>
    <div class="row">
        <?php
        $fruits = ["Lemon", "Strawberry", "Watermelon", "Banana", "Grapes", "Kiwi Fruit", "Green Apple", "Red Apple", "Pineapple"];

        foreach ($fruits as $value) {
            if ($value == "Lemon") {
                echo "<div class='col-1'>";
            } else {
                echo "<div class='col-1 m-l'>";
            }
            echo "<div class='card'><img src='../img/$value.png' alt='' class='image'>
            <div class='text-center'>
                <div class='card-title'>$value</div>
            </div>
            <a href='./menu.php?item=$value' class='btn btn-sm btn-success'>Add</a>
        </div>
    </div>";
        }
        ?>
    </div>

    <h4 class="m-t"><img src='../img/Dessert.png' alt='' style="width:32px;"> Dessert</h4>
    <div class="row">
        <?php
        $dessert = ["Shortcake", "Doughnut", "Cookie", "Ice Cream", "Cupcake", "Candy"];

        foreach ($dessert as $value) {
            if ($value == "Shortcake") {
                echo "<div class='col-1'>";
            } else {
                echo "<div class='col-1 m-l'>";
            }
            echo "<div class='card'><img src='../img/$value.png' alt='' class='image'>
            <div class='text-center'>
                <div class='card-title'>$value</div>
            </div>
            <a href='./menu.php?item=$value' class='btn btn-sm btn-success'>Add</a>
        </div>
    </div>";
        }
        ?>
    </div>

    <h4 class="m-t"><img src='../img/drinks.png' alt='' style="width:32px;">Drinks</h4>
    <div class="row m-b">
        <?php
        $drinks = ["Glass of Milk", "Coffee", "Apple Juice", "Bubble Tea"];

        foreach ($drinks as $value) {
            if ($value == "Glass of Milk") {
                echo "<div class='col-1'>";
            } else {
                echo "<div class='col-1 m-l'>";
            }
            echo "<div class='card'><img src='../img/$value.png' alt='' class='image'>
            <div class='text-center'>
                <div class='card-title'>$value</div>
            </div>
            <a href='./menu.php?item=$value' class='btn btn-sm btn-success'>Add</a>
        </div>
    </div>";
        }
        ?>
    </div>
</body>

</html>