<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $i = isset($_POST['i']) ? $_POST['i'] : "";
    $adopt_id = $_SESSION['adopt_id'];
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT review_id FROM review_record WHERE adopt_id = '$adopt_id' ORDER BY review_id ASC LIMIT $i, 1"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $review_id = $row['review_id'];
    if ($review_id) {
        $sql_delete = "DELETE FROM review_record WHERE review_id = '$review_id'";
        mysqli_query($conn, $sql_delete);
    }
    mysqli_close($conn); //关闭数据库
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
echo "<script>history.go(-1);</script>";
