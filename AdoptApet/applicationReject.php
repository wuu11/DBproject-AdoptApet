<?php
header("Content-Type: text/html;charset=utf-8");
$application = isset($_POST['application']) ? $_POST['application'] : "";

session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $account = $_SESSION['user'];
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); 
    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $administrator = $row['administrator_id'];
    $sql_update = "UPDATE application SET state = '2', administrator_id = '$administrator', process_time = NOW() WHERE application_id = '$application'";
    mysqli_query($conn, $sql_update);
    mysqli_close($conn);
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
