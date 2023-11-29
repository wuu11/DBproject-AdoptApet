<?php
header("Content-Type: text/html;charset=utf-8");

//声明变量
$account = isset($_POST['account']) ? $_POST['account'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$re_password = isset($_POST['re_password']) ? $_POST['re_password'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$age = isset($_POST['age']) ? $_POST['age'] : "";
$sex = isset($_POST['sex']) ? $_POST['sex'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$address = isset($_POST['address']) ? $_POST['address'] : "";

if ($password == $re_password) { 
    
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT account FROM userInfo WHERE account = '$account'"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret); 
   
    if ($account == $row['account']) { 
        echo "<script>alert('账号已存在！');location='html/register.html'</script>";
    } else { 
        $sql_insert = "INSERT INTO userInfo(account, password, role, state)
        VALUES('$account', '$password', '0', '1')"; //role=0代表普通用户，state=1代表该账号处于正常状态
        mysqli_query($conn, $sql_insert);
        $sql_insert = "INSERT INTO common_user(account, full_name, age, sex, phone, email, personal_address)
        VALUES('$account', '$name', '$age', '$sex', '$phone', '$email', '$address')"; //role=0代表普通用户，state=1代表该账号处于正常状态
        mysqli_query($conn, $sql_insert);
        //开启session
        session_start();
        $_SESSION['user'] = $account;
        $_SESSION['role'] = 0;
        echo "<script>alert('注册成功');location='index.php'</script>";
    } 
    mysqli_close($conn); //关闭数据库
} else {
    echo "<script>alert('密码不一致！');location='html/register.html'</script>";
} 
?>