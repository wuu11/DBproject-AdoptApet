<!DOCTYPE html>
<html>
<head>
    <title>我的申请</title>
    <link rel="stylesheet" href="css/application.css">
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="header">
        <a href="myApplication.php" class="logo">
            <h1>Adopt A Pet</h1>
        </a>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">主页</a></li>
                <li><a href="myApplication.php">我的申请</a></li>
                <li><a href="personalInfo.php">个人信息</a></li>
            </ul>
        </nav>
    </div>
    <div><br><br><br></div>
    <?php 
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    if (isset($_SESSION['user'])) {
        $account = $_SESSION['user'];
        $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
        $sql_select = "SELECT application_id, application.pet_id, nickname, variety_name, propose_time, state, application.administrator_id, process_time FROM common_user, application, pet, variety WHERE common_user.user_id = application.user_id AND application.pet_id = pet.pet_id AND pet.variety_id = variety.variety_id AND account = '$account'"; 
        $ret = mysqli_query($conn, $sql_select);
        while ($row = mysqli_fetch_assoc($ret)) { ?>
            <div class="container">
                <h2 class="title">#<?php echo $row['application_id']?></h2>
                <p class="info">宠物：#<?php echo $row['pet_id']?>  <?php echo $row['nickname']?>  <?php echo $row['variety_name']?><br>发起时间：<?php echo $row['propose_time']?><br>
                状态：<?php switch ($row['state']) {
                            case 0:
                                echo "未处理";
                                break;
                            case 1:
                                echo "已批准";
                                break;
                            case 2:
                                echo "已驳回";
                                break;
                        }?><br>
                处理人：管理员#<?php echo $row['administrator_id']?> 处理时间：<?php echo $row['process_time']?><br></p>
            </div>
        <?php }
        mysqli_close($conn); //关闭数据库
    } else {
        echo "<script>alert('请先登录！');location='html/login.html'</script>";
    } ?>
</body>
</html>