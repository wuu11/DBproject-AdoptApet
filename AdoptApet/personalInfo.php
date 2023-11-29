<!DOCTYPE html>
<html>
<head>
    <title>个人信息</title>
    <link rel="stylesheet" href="css/personalInfo.css">
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="header">
        <a href="personalInfo.php" class="logo">
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
    <div id="bigBox">
        <h1>个人信息</h1>
        <?php 
        header("Content-Type: text/html;charset=utf-8");
        session_start();
        if (isset($_SESSION['user'])) {
            $account = $_SESSION['user'];
            $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
            $sql_select = "SELECT account, user_id, full_name, age, sex, phone, email, personal_address FROM common_user WHERE account = '$account'"; 
            $ret = mysqli_query($conn, $sql_select);
            $row = mysqli_fetch_array($ret);
            ?>
                <tr>账号：<?php echo $row['account']?></tr><br>
                <tr>编号：<?php echo $row['user_id']?></tr><br>
                <tr>姓名：<td class="edit" id="name"><?php echo $row['full_name']?></td></tr><br>
                <tr>年龄：<td class="edit" id="age"><?php echo $row['age']?></td></tr><br>
                <tr>性别：<td class="edit" id="sex"><?php switch ($row['sex']) {
                            case 'M':
                                echo "M(Male)";
                                break;
                            case 'F':
                                echo "F(Female)";
                                break;
                        }?></td></tr><br>
                <tr>电话：<td class="edit" id="phone"><?php echo $row['phone']?></td></tr><br>
                <tr>邮箱：<td class="edit" id="email"><?php echo $row['email']?></td></tr><br>
                <tr>地址：<td class="edit" id="address"><?php echo $row['personal_address']?></td></tr><br>
                <tr><button type="button" class="btn" onclick="showPrompt('infoChangeModal')">修改</button></tr>
            <?php
            mysqli_close($conn); //关闭数据库
        } else {
            echo "<script>alert('请先登录！');location='html/login.html'</script>";    
        }?>
    </div>
    <div id="infoChangeModal" class="modal">
        <div class="modal-title">个人信息</div>
        <div class="modal-content">
            <span class="close">&times;</span>
                <?php 
                header("Content-Type: text/html;charset=utf-8");
                session_start();
                if (isset($_SESSION['user'])) {
                    $account = $_SESSION['user'];
                    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
                    $sql_select = "SELECT user_id, full_name, age, sex, phone, email, personal_address FROM common_user WHERE account = '$account'"; 
                    $ret = mysqli_query($conn, $sql_select);
                    $row = mysqli_fetch_array($ret);
                ?>
                <form id="infoform" action="infoChange.php" method="post">
                    <label for="input1">姓名：</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['full_name']?>"><br>
                    <label for="input2">年龄：</label>
                    <input type="number" id="age" min="0" max="120" name="age" value="<?php echo $row['age']?>"><br>
                    <label for="input3">性别：</label>
                    <input type="text" id="sex" name="sex" value="<?php echo $row['sex']?>"><br>
                    <label for="input4">电话：</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $row['phone']?>"><br>
                    <label for="input5">邮箱：</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']?>"><br>
                    <label for="input6">地址：</label>
                    <input type="text" id="address" name="address" value="<?php echo $row['personal_address']?>"><br>
                    <div slot="footer">
                        <input type="submit" id="confirm" name="confirm" value="确认" class="btn">
                    </div>
                </form>
                <?php /*
                    $name = isset($_POST['name']) ? $_POST['name'] : "";
                    $age = isset($_POST['age']) ? $_POST['age'] : "";
                    $sex = isset($_POST['sex']) ? $_POST['sex'] : "";
                    $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
                    $email = isset($_POST['email']) ? $_POST['email'] : "";
                    $address = isset($_POST['address']) ? $_POST['address'] : "";
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
                    if ($address != $row['address'] && $address != "") {
                        $sql_update = "UPDATE common_user SET personal_address = '$address' WHERE account = '$account'";
                        mysqli_query($conn, $sql_update);
                    }
                    if (isset($_POST['name'])) {
                        session_start();
                        $pet = $_SESSION['pet'];
                        $user_id = $row['user_id'];
                        $sql_insert = "INSERT INTO application(pet_id, user_id, state, propose_time)
                        VALUES('$pet', '$user_id', '0', NOW())"; 
                        mysqli_query($conn, $sql_insert); 
                    }
                    mysqli_close($conn); //关闭数据库 */
                } else {
                    echo "<script>alert('请先登录！');location='html/login.html'</script>";
                } ?>
        </div>
    </div>
    <script type="text/javascript">
        // 打开模态框
        function showPrompt(id) {
            var mo = document.getElementById(id);
            mo.style.display = "block";
        }
    </script>
</body>
</html>