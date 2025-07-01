<?php
session_start();
$index = $_GET["KUNCI"];

$_SESSION["daftar"][$index] = [
    "nama" => $_POST["nama"],
    "umur" => $_POST["umur"]
];

header("Location: dashboard.php");

?>