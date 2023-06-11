    <?php
    require_once("../scripts/authentication.php");

    require_once("../scripts/conn_db.php");

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['role']) && isset($_SESSION['updateUserId'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $sql = "UPDATE `users` SET `name`=?, `email`=?, `role`=? WHERE `id`=?";
        $stmt = $conn->prepare($sql);

        $name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $role = validate($_POST['role']);
        $id = validate($_SESSION['updateUserId']);


        if ($role == 1) {
            $role = "Student";
        } else {
            $role = "Administrator";
        }

        $stmt->bind_param('sssi', $name, $email, $role, $id);
        $stmt->execute();

        unset($_SESSION['updateUserId']);

        header("Location: ../pages/control_panel.php?info=User with id $id was successfully updated.");
        exit();
    }
    ?>
    