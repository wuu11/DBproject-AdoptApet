<?php
header("Content-Type: text/html;charset=utf-8");
$application = isset($_POST['application']) ? $_POST['application'] : "";

session_start();
if (isset($_SESSION['user'])) {
    $account = $_SESSION['user'];
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); 
    $sql_update = "UPDATE application SET state = '3' WHERE application_id = '$application'";
    mysqli_query($conn, $sql_update);
    mysqli_close($conn);
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
