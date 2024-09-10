<!DOCTYPE html>
<html>
<head>
    <title>回访记录</title>
    <link rel="stylesheet" href="css/application.css">
    <script src="js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="loader"></div>
    <div class="header">
        <a href="reviewRecord.php" class="logo">
            <h1>Adopt A Pet</h1>
        </a>
        <nav class="navbar">
            <ul>
                <li><a href="index_admin.php">主页</a></li>
                <li><a href="allApplication.php">申请列表</a></li>
                <li><a href="adoptRecord.php">领养记录</a></li>
                <li><a href="reviewRecord.php">回访记录</a></li>
            </ul>
        </nav>
    </div><br><br><br></div>
    <?php 
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
        $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
        $sql_select = "SELECT * FROM review_record"; 
        $ret = mysqli_query($conn, $sql_select);

        while ($row = mysqli_fetch_array($ret)) { 
            $adopt_id = $row['adopt_id'];
            $sql_select = "SELECT * FROM viewAdoptInfo WHERE adopt_id = '$adopt_id' ORDER BY adopt_id ASC"; 
            $ret_adopt = mysqli_query($conn, $sql_select);
            $row_adopt = mysqli_fetch_array($ret_adopt);?>
            <div class="container">
                <h2 class="title">#<?php echo $row['review_id']?></h2>
                <p class="info">领养记录号：<?php echo $adopt_id?>
                <a href="#modal-opened<?php echo $adopt_id?>" class="link-1" id="modal-closed<?php echo $adopt_id?>">详细信息</a>
                <br>
                回访人：管理员#<?php echo $row['administrator_id']?><br>回访时间：<?php echo $row['review_time']?><br>
                回访情况：<?php echo $row['situation']?><br>创建时间：<?php echo $row['create_time']?></p>
            </div>
            <div class="modal-container" id="modal-opened<?php echo $adopt_id?>">
                <div class="modal">
                    <div class="modal_details">
                        <h1 class="modal_title" id>领养记录号#<?php echo $adopt_id?></h1>
                        <p class="modal_description">被领养宠物：#<?php echo $row_adopt['pet_id']?>&nbsp;&nbsp;<?php echo $row_adopt['nickname']?>&nbsp;&nbsp;<?php echo $row_adopt['variety_name']?></p>
                    </div>
                    <p class="modal_text">领养人姓名：<?php echo $row_adopt['full_name']?><br>领养人联系电话：<?php echo $row_adopt['phone']?><br>领养人地址：<?php echo $row_adopt['personal_address']?></p>
                    <a href="#modal-closed<?php echo $adopt_id?>" class="link-2"></a>
                </div>
            </div>
        <?php }
        mysqli_close($conn); //关闭数据库
    } else {
        echo "<script>alert('请先登录！');location='html/login.html'</script>";
    } ?>
    
    <script>
        /*--------- Loader ----------*/
        $(window).on("load", function () {
            $('.loader').fadeOut(1500, function () {
                $(this).remove();
            });
        });
    </script>
</body>
</html>