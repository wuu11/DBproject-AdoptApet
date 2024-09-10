<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $pet = isset($_POST['pet']) ? $_POST['pet'] : "";
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT pet_id FROM adopt_record WHERE pet_id = '$pet'"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    if ($row['pet_id'] != null) {
        $sql_delete = "DELETE FROM application WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_delete);
        $sql_delete = "DELETE FROM pet WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_delete);
    }
    mysqli_close($conn); //关闭数据库
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
echo "<script>history.go(-1);</script>";
