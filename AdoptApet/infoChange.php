<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $age = isset($_POST['age']) ? $_POST['age'] : "";
    $sex = isset($_POST['sex']) ? $_POST['sex'] : "";
    $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $address = isset($_POST['address']) ? $_POST['address'] : "";

    $account = $_SESSION['user'];
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT user_id, full_name, age, sex, phone, email, personal_address FROM common_user WHERE account = '$account'"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    if ($name != $row['full_name'] && $name != "") {
        $sql_update = "UPDATE common_user SET full_name = '$name' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    if ($age != $row['age'] && $age != "") {
        $sql_update = "UPDATE common_user SET age = '$age' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    if ($sex != $row['sex'] && $sex != "") {
        $sql_update = "UPDATE common_user SET sex = '$sex' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    if ($phone != $row['phone'] && $phone != "") {
        $sql_update = "UPDATE common_user SET phone = '$phone' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    if ($email != $row['email'] && $email != "") {
        $sql_update = "UPDATE common_user SET email = '$email' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    if ($address != $row['personal_address'] && $address != "") {
        $sql_update = "UPDATE common_user SET personal_address = '$address' WHERE account = '$account'";
        mysqli_query($conn, $sql_update);
    }
    mysqli_close($conn); //关闭数据库
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
} 
