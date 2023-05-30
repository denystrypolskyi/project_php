<?php

require_once("../scripts/conn_db.php");

require_once("../scripts/authentication.php");

if ($_SESSION['role'] != 'Administrator') {
    header("Location: ./home.php");
}

if ($_GET['updateUserId'] == $_SESSION['id']) {
    header("Location: ../pages/control_panel.php?error=You can't edit your own account.");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Control Panel</title>
    <style>
        input {
            color: #947361 !important;
        }

        select {
            color: #947361 !important;
        }
    </style>
</head>

<body>
    <div class="con">
        <?php
        require_once('../partials/header.php');
        $_SESSION['updateUserId'] = $_GET['updateUserId'];
        ?>
        <div class="card">
            <div class="card-body">
                <div class="card-title">Update User Data</div>
                <form action="../scripts/update_user.php" method="post">
                    <fieldset disabled>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><img src="../img/list-ol.svg" alt="" class="filter-brown"></span>
                            <input type="text" class="form-control" <?php echo "value=$_GET[updateUserId]" ?> name="id" required autocomplete="off">
                        </div>
                    </fieldset>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="../img/card-text.svg" alt="" class="filter-brown"></span>
                        <?php
                        $name = str_replace(" ", " ", $_GET['name']);
                        echo "<input type='text' class='form-control' value='$_GET[name]' name='name' required autocomplete='off'>"
                        ?>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="../img/envelope-fill.svg" alt="" class="filter-brown"></span>
                        <input type="email" class="form-control" <?php echo "value=$_GET[email]" ?> name="email" required autocomplete="off">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="../img/role.png" alt="" class="filter-brown" style="width:17.5px;height:17.5;"></span>
                        <select class="form-select" aria-label=".form-select-sm example" name="role">
                            <?php
                            if ($_GET['role'] == 'Student') {
                                echo '<option selected value="1">Student</option>
                                <option value="2">Administrator</option>';
                            } else {
                                echo '<option value="1">Student</option>
                                <option selected value="2">Administrator</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Update</button>
                    <a href="./control_panel.php" class="btn btn-outline-danger ms-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>