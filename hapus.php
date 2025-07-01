<?php
session_start();
$id = $_GET['kunci'];
unset($_SESSION["daftar"][$id]);
header("location: dashboard.php");
?>