<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
$pet = $_SESSION['pet'];
if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
    $pet = $_SESSION['pet'];
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
        $target_path = null;
    } else {
        echo "<script>alert('照片上传失败')</script>";
        $target_path = null;
    }
    
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT nickname, variety_id, birthday, age, sex, colour, personality, health, photo_path, adopt_state FROM pet WHERE pet_id = '$pet'"; 
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);

    if ($nickname != $row['nickname'] && $nickname != "") {
        $sql_update = "UPDATE pet SET nickname = '$nickname' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($variety != $row['variety_id'] && $variety != "") {
        $sql_update = "UPDATE pet SET variety_id = '$variety' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($birthday != $row['birthday'] && $birthday != "") {
        $sql_update = "UPDATE pet SET birthday = '$birthday' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($age != $row['age'] && $age != "") {
        $sql_update = "UPDATE pet SET age = '$age' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($sex != $row['sex'] && $sex != "") {
        $sql_update = "UPDATE pet SET sex = '$sex' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($colour != $row['colour'] && $colour != "") {
        $sql_update = "UPDATE pet SET colour = '$colour' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($personality != $row['personality'] && $personality != "") {
        $sql_update = "UPDATE pet SET personality = '$personality' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($health != $row['health'] && $health != "") {
        $sql_update = "UPDATE pet SET health = '$health' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    if ($target_path != null) {
        $sql_update = "UPDATE pet SET photo_path = '$target_path' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
        if ($row['photo_path'] != "images/pet.png" && file_exists($row['photo_path'])) {
            unlink($row['photo_path']);
        }
    }
    if ($adopt_state != $row['adopt_state'] && $adopt_state != "") {
        $sql_update = "UPDATE pet SET adopt_state = '$adopt_state' WHERE pet_id = '$pet'";
        mysqli_query($conn, $sql_update);
    }
    $sql_update = "UPDATE pet SET last_update_time = NOW() WHERE pet_id = '$pet'";
    mysqli_query($conn, $sql_update);
    mysqli_close($conn); //关闭数据库
} else {
    echo "<script>alert('请先登录！');location='html/login.html'</script>";
}
echo "<script>history.go(-1);</script>";
