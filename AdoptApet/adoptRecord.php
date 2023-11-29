<!DOCTYPE html>
<html>
<head>
    <title>领养记录</title>
    <link rel="stylesheet" href="css/application.css">
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="header">
        <a href="adoptRecord.php" class="logo">
            <h1>Adopt A Pet</h1>
        </a>
        <nav class="navbar">
            <ul>
                <li><a href="index_admin.php">主页</a></li>
                <li><a href="allApplication.php">申请列表</a></li>
                <li><a href="adoptRecord.php">领养记录</a></li>
                <li><a href="reviewRecord.php">回访记录</a></li>
                <li><a href="userAdmin.php">用户管理</a></li>
            </ul>
        </nav>
    </div>
    <div><br><br><br></div>
    <?php 
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
        $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
        $sql_select = "SELECT * FROM viewAdoptInfo ORDER BY adopt_id ASC"; 
        $ret = mysqli_query($conn, $sql_select);

        while ($row = mysqli_fetch_array($ret)) { ?>
            <div class="container">
                <h2 class="title">#<?php echo $row['adopt_id']?></h2>
                <p class="info">领养人姓名：<?php echo $row['full_name']?><br>领养人联系电话：<?php echo $row['phone']?><br>领养人地址：<?php echo $row['personal_address']?><br>
                领养宠物：#<?php echo $row['pet_id']?>  <?php echo $row['nickname']?>  <?php echo $row['variety_name']?><br>领养时间：<?php echo $row['adopt_time']?></p>
            </div>
        <?php }
        mysqli_close($conn); //关闭数据库
    } else {
        echo "<script>alert('请先登录！');location='html/login.html'</script>";
    } ?>
</body>
</html>