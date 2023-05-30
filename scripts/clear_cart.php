<?php
require_once("../scripts/authentication.php");

unset($_SESSION["list"]);

header("location: ../pages/menu.php");
