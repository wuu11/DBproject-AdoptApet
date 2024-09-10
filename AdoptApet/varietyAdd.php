<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $account = $_SESSION['user'];
    $variety_name = isset($_POST['variety_name']) ? $_POST['variety_name'] : "";
    $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : "";
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $administrator = $row['administrator_id'];
    $sql_insert = "INSERT INTO variety(administrator_id, variety_name, introduction)
                VALUES('$administrator', '$variety_name', '$introduction')";
    mysqli_query($conn, $sql_insert);
    mysqli_close($conn); //关闭数据库
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
} 
