<?php
header("Content-Type: text/html;charset=utf-8");

//声明变量
$account = isset($_POST['account']) ? $_POST['account'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";

if (!empty($account) && !empty($password)) { 
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT account, password, role FROM userInfo WHERE account = '$account' AND password = '$password'"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret); 

    if ($account == $row['account'] && $password == $row['password']) { 
        //开启session
        session_start(); 
        $_SESSION['user'] = $account; 
        $_SESSION['role'] = $row['role'];
        if($row['role'] == 0) {
            header("Location: index.php");
        } else {
            header("Location: index_admin.php");
        }
        mysqli_close($conn); //关闭数据库
    }
    else {
        echo "<script>alert('账号不存在或密码错误！');location='html/login.html'</script>";
    }
} else { 
    echo "<script>alert('账号或密码为空！');location='html/login.html'</script>";
}
