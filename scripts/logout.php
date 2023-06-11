<?php

require_once("../scripts/authentication.php");

session_unset();

session_destroy();

header("Location: ../pages/login.php");
exit();
