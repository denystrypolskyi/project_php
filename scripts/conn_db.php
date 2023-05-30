<?php

$sHost = "localhost";
$sName = "root";
$sPassword = "";
$db_Name = "project_db";

$conn = mysqli_connect($sHost, $sName, $sPassword, $db_Name);

if(!$conn)
{
    echo "Connection failed";
}

?>