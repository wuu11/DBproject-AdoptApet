<?php
header("Content-Type: text/html;charset=utf-8");
$pet = isset($_POST['pet']) ? $_POST['pet'] : "";
session_start();
$_SESSION['pet'] = $pet;
?>