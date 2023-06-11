<?php
require_once("../scripts/conn_db.php");

require_once("../scripts/authentication.php");

if ($_SESSION['role'] != 'Administrator') {
    header("Location: ./home.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Control Panel</title>
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
    ?>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th scope="col"><img src="../img/list-ol.svg" alt="" class="filter-brown"> Id</th>
                <th scope="col"><img src="../img/card-text.svg" alt="" class="filter-brown"> Name</th>
                <th scope="col"><img src="../img/envelope-fill.svg" alt="" class="filter-brown"> Email</th>
                <th scope="col"><img src="../img/role.png" alt="" class="filter-brown" style="width:17.5px;height:17.5;"> Role</th>
                <th colspan="2" scope="col"><img src="../img/gear-fill.svg" alt="" class="filter-brown"> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, name, email, role from users where id>?";
            $stmt = $conn->prepare($sql);
            $id = 0;
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($user = $result->fetch_assoc()) {
                echo "<tr><th scope='row'><p>$user[id]</p></th>
                    <td><p>$user[name]</p></td>
                    <td><p>$user[email]</p></td>
                    <td><p>";
                if ($user['role'] == 'Administrator') {
                    echo "<img src='../img/person-fill-gear.svg' alt=''class='filter-brown'> $user[role]</p></td>";
                } else {
                    echo "<img src='../img/person-fill.svg' alt=''class='filter-brown'> $user[role]</p></td>";
                }
                $nameUnlencode = urlencode($user['name']);
                echo "<td><img src='../img/person-fill-x.svg' alt=''class='filter-brown'><a href='../scripts/delete_user.php?deleteUserId=$user[id]' style='text-decoration: none;font-weight: normal;color: #947361;'> Delete</a></td>";
                echo "<td><img src='../img/file-person-fill.svg' alt=''class='filter-brown'><a href='./update_user.php?updateUserId=$user[id]&name=$nameUnlencode&email=$user[email]&role=$user[role]' style='text-decoration: none; font-weight: normal; color: #947361'> Edit</a></td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>