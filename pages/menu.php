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
        echo <<< ERRORS
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="text-center">
        $_GET[info]
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ERRORS;
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
            echo "<span style='top:20px;left:12.5px; position: absolute;font-weight: bold;font-size:20px; color:#947361'>Cart (" . $total_quantity . ")</span>";
            echo "<a href='../scripts/clear_cart.php' style='top:28.5px;right:12.5px; position: absolute;font-weight: normal;font-size:13px; text-decoration:none;color:#50a684'>Clear</a>";
            echo '</div>';
            echo '<ul class="list-group list-group-flush" style="width:200px; margin-top:20px;">';
            foreach ($list as $key => $value) {
                echo '<li class="list-group-item">';
                echo '<img src="../img/' . $key . '.png" alt="" style="width:30px; margin-right:10px; padding-right:10px;">';
                echo "<strong>$key</strong>";
                echo '<a href="./menu.php?removeItem=' . $key . '" class="float-end" style="font-size:15px; text-decoration:none; margin-left: 5px;">';
                echo '<strong style="color: #50a684;">-</strong>';
                echo '</a>';
                echo '<strong class="float-end" style="font-size:15px; text-decoration:none; margin-left:5px;"">' . $value . '</strong>';
                echo '<a href="./menu.php?item=' . $key . '" class="float-end" style="font-size:15px; text-decoration:none;">';
                echo '<strong style="color: #50a684;">+</strong>';
                echo '</a>';
                echo '</li>';
            }
            echo "</ul>";
            $dateNow = date("Y-m-d");
            echo <<< FORM
                <form action='../scripts/order_food.php' method='post'>
                <div class='input-group mt-3'>
                    <input type='date' class='form-control' style='color: #947361; height:30px; font-weight: bold;' value='$dateNow' name='date'>
                </div>
                <button type='submit' class='btn btn-sm btn-success' style='width:100%; margin-top:12px;'>Order</button>
                </form>
        FORM;
            echo '</div>';
        } else {
            echo <<< EMPTYCART
                    <div class="card" style="width:225px;">
                        <div class="card-body">
                            <img class="card-img" src="../img/Cart.png" alt="">
                        </div>
                        <div class="text-center">
                            <p class="card-text text-muted">Your cart is empty. Add items from the menu.</p>
                        </div>
                    </div>
                EMPTYCART;
            // echo <<< EMPTYCART
            //         <div class="card" style="width:225px;">
            //         <div class="card-body">
            //             <h5 class='card-title' style="text-align:center;">Cart is empty<span data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
            //                     <img src="../img/caret-down-fill.svg" alt="" class="filter-brown">
            //                 </span></h5>
            //             <div class="collapse show" id="collapseExample">
            //                 <div class="text-center">
            //                     <img class="card-img" src="../img/Cart.png" alt="">
            //                     <p class="card-text" style="margin-top:15px;">Your cart is empty. Add items from the menu.</p>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     EMPTYCART;
        }
    }
    ?>
    <h4 class="m-t">Food</h4>
    <div class="row">
        <div class="col-1">
            <div class="card"><img src="../img/spaghetti.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Spaghetti</div>
                </div>
                <a href="./menu.php?item=Spaghetti" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/hamburger.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Hamburger</div>
                </div>
                <a href="./menu.php?item=Hamburger" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/sandwich.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Sandwich</div>
                </div>
                <a href="./menu.php?item=Sandwich" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/Green Salad.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Green Salad</div>
                </div>
                <a href="./menu.php?item=Green Salad" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/bacon.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Bacon</div>
                </div>
                <a href="./menu.php?item=Bacon" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/pizza.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Pizza</div>
                </div>
                <a href="./menu.php?item=Pizza" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/Hot Dog.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Hot Dog</div>
                </div>
                <a href="./menu.php?item=Hot Dog" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
    </div>

    <h4 class="m-t">Drinks</h4>
    <div class="row gx-5">
        <div class="col-1">
            <div class="card"><img src="../img/Glass of Milk.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Glass of Milk</div>
                </div>
                <a href="./menu.php?item=Glass of Milk" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l">
            <div class="card"><img src="../img/Coffee.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Coffee</div>
                </div>
                <a href="./menu.php?item=Coffee" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
        <div class="col-1 m-l m-b">
            <div class="card"><img src="../img/Apple Juice.png" alt="" class="image">
                <div class="text-center">
                    <div class="card-title">Apple Juice</div>
                </div>
                <a href="./menu.php?item=Apple Juice" class="btn btn-sm btn-success">Add</a>
            </div>
        </div>
    </div>
    <!-- <h2 class="m-t">Fruits</h2>
        <div class="row gx-5">
            <div class="col-1">
                <div class="card"><img src="../img/lemon.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Lemon</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/peanuts.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Peanuts</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/cucumber.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Cucumber</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/kiwi_fruit.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Kiwi Fruit</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/green_apple.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Green Apple</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/red_apple.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Red Apple</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="m-t">Vegetables</h2>
        <div class="row gx-5">
            <div class="col-1">
                <div class="card"><img src="../img/carrot.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Carrot</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/peach.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Peach</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/broccoli.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Broccoli</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="m-t">Berries</h2>
        <div class="row">
            <div class="col-1">
                <div class="card"><img src="../img/strawberry.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Strawberry</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/watermelon.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Watermelon</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/banana.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Banana</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/grapes.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Grapes</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="m-t">Dessert</h2>
        <div class="row">
            <div class="col-1">
                <div class="card"><img src="../img/shortcake.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Shortcake</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/doughnut.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Doughnut</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/cookie.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Cookie</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
            <div class="col-1 m-l">
                <div class="card"><img src="../img/chocolate_bar.png" alt="">
                    <div class="text-center">
                        <div class="card-title">Chocolate Bar</div>
                        <a href="">Add</a>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- <nav class="navbar navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Menu
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class='card'>
                    <img src=" ../img/food1.png" class='card-img-top' alt="item">
                    <div class='card-body'>
                        <h5 class='card-title'>Food #1</h5>
                        <p class='card-text'>Fried popcorn chicken, mashed potatoes, peas, fruit cup, chocolate-chip cookie.</p>
                        <input type="date" style="width: 250px; display:inline; height: 37px">
                        <a href='#' class='btn btn-outline-primary rounded-0 float-end'>Order</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class='card'>
                    <img src=" ../img/food1.png " class='card-img-top' alt="item">
                    <div class='card-body'>
                        <h5 class='card-title'>Food #2</h5>
                        <p class='card-text'>Steak, carrots, green beans, cheese, fresh fruit.</p>
                        <input type="date" style="width: 250px; display:inline; height: 37px ">
                        <a href='#' class='btn btn-outline-primary rounded-0 float-end'>Order</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class='card'>
                    <img src=" ../img/food1.png " class='card-img-top' alt="item">
                    <div class='card-body'>
                        <h5 class='card-title'>Food #3</h5>
                        <p class='card-text'>Sautéed shrimp, brown rice, veggies, gazpacho, fresh peppers, bread, orange.</p>
                        <input type="date" style="width: 250px; display:inline; height: 37px;">
                        <a href='#' class='btn btn-outline-primary rounded-0 float-end'>Order</a>

                    </div>
                </div>
            </div>

        </div>
    </div> -->

</body>

</html>