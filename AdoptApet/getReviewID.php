<?php
header("Content-Type: text/html;charset=utf-8");
$adopt_id = isset($_POST['adopt_id']) ? $_POST['adopt_id'] : "";
session_start();
$_SESSION['adopt_id'] = $adopt_id;
