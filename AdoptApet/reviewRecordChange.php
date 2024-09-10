<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $i = isset($_POST['i']) ? $_POST['i'] : "";
    $situation = isset($_POST['text']) ? $_POST['text'] : "";
    $adopt_id = $_SESSION['adopt_id'];
    $account = $_SESSION['user'];
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $administrator = $row['administrator_id'];
    $sql_select = "SELECT review_id, administrator_id FROM review_record WHERE adopt_id = '$adopt_id' ORDER BY review_id ASC LIMIT $i, 1"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $review_id = $row['review_id'];
    if ($administrator == $row['administrator_id']) {
        $sql_update = "UPDATE review_record SET situation = '$situation' WHERE review_id = '$review_id'";
        mysqli_query($conn, $sql_update);
        mysqli_close($conn); //关闭数据库
    } else {
        echo "<script>alert('抱歉，您没有修改这条记录的权限！');</script>";
    } 
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
echo "<script>history.go(-1);</script>";
