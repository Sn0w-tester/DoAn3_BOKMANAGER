<?php

$sName ="localhost";
$uname = "root";
$pass = "";
$db_name = "BOKMANAGER_db";

try {
    $conn = new PDO("mysql:host=$sName; dbname=$db_name", $uname, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: ". $e->getMessage();
}
