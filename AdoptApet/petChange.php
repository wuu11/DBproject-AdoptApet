<?php
header("Content-Type: text/html;charset=utf-8");

$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : "";
$variety = isset($_POST['variety']) ? $_POST['variety'] : "";
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : "";
$age = isset($_POST['age']) ? $_POST['age'] : "";
$sex = isset($_POST['sex']) ? $_POST['sex'] : "";
$colour = isset($_POST['colour']) ? $_POST['colour'] : "";
$personality = isset($_POST['personality']) ? $_POST['personality'] : "";
$health = isset($_POST['health']) ? $_POST['health'] : "";
$adopt_state = isset($_POST['adopt_state']) ? $_POST['adopt_state'] : "";

session_start();
$pet = $_SESSION['pet'];
$conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
$sql_select = "SELECT nickname, variety_id, birthday, age, sex, colour, personality, health, adopt_state FROM pet WHERE pet_id = '$pet'"; 
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
if ($adopt_state != $row['adopt_state'] && $adopt_state != "") {
    $sql_update = "UPDATE pet SET adopt_state = '$adopt_state' WHERE pet_id = '$pet'";
    mysqli_query($conn, $sql_update);
}
$sql_update = "UPDATE pet SET last_update_time = NOW() WHERE pet_id = '$pet'";
mysqli_query($conn, $sql_update);
mysqli_close($conn); //关闭数据库
echo "<script>history.go(-1);</script>";
?>