<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $account = $_SESSION['user'];
    $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : "";
    $variety = isset($_POST['variety']) ? $_POST['variety'] : "";
    $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : "";
    $age = isset($_POST['age']) ? $_POST['age'] : "";
    $sex = isset($_POST['sex']) ? $_POST['sex'] : "";
    $colour = isset($_POST['colour']) ? $_POST['colour'] : "";
    $personality = isset($_POST['personality']) ? $_POST['personality'] : "";
    $health = isset($_POST['health']) ? $_POST['health'] : "";
    $adopt_state = isset($_POST['adopt_state']) ? $_POST['adopt_state'] : "";
    $photo = $_FILES['photo'];
    if ($photo['error'] == UPLOAD_ERR_OK) {
        // 定义存储图片的位置
        $target_dir = "uploads/";
        $target_path = $target_dir.time()."-".basename($photo['name']);
        // 将图片移动到指定位置
        move_uploaded_file($photo['tmp_name'], $target_path);
    } else if ($photo['error'] == UPLOAD_ERR_NO_FILE) {
        $target_path = "images/pet.png";
    } else {
        echo "<script>alert('照片上传失败')</script>";
        $target_path = "images/pet.png";
    }
    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
    mysqli_set_charset($conn,"utf8");
    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    $administrator = $row['administrator_id'];
    $sql_insert = "INSERT INTO pet(variety_id, administrator_id, nickname, birthday, age, sex, colour, personality, health, photo_path, adopt_state, last_update_time)
                VALUES('$variety', '$administrator', '$nickname', '$birthday', '$age', '$sex', '$colour', '$personality', '$health', '$target_path', '$adopt_state', NOW())";
    mysqli_query($conn, $sql_insert);
    mysqli_close($conn); //关闭数据库
    echo "<script>history.go(-1);</script>";
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
} 
