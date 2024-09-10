<?php
header("Content-Type: text/html;charset=utf-8");
$review_time = isset($_POST['reviewtime']) ? $_POST['reviewtime'] : "";
$situation = isset($_POST['text']) ? $_POST['text'] : "";
session_start();
$adopt_id = $_SESSION['adopt_id'];
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $account = $_SESSION['user'];
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $administrator = $row['administrator_id'];
    $sql_insert = "INSERT INTO review_record(adopt_id, administrator_id, review_time, situation, create_time)
                VALUES('$adopt_id', '$administrator', '$review_time', '$situation', NOW())";
    mysqli_query($conn, $sql_insert);
    mysqli_close($conn); //关闭数据库
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
} 