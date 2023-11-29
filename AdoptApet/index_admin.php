<!DOCTYPE html>
<html>
<head>
    <title>主页</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="header">
        <a href="index_admin.php" class="logo">
            <h1>Adopt A Pet</h1>
        </a>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">主页</a></li>
                <li><a href="allApplication.php">申请列表</a></li>
                <li><a href="adoptRecord.php">领养记录</a></li>
                <li><a href="reviewRecord.php">回访记录</a></li>
                <li><a href="userAdmin.php">用户管理</a></li>
            </ul>
        </nav>
    </div>
    <div><br><br><br></div>
    <main class="page-content">
    <?php
    ob_start();
    header("Content-Type: text/html;charset=utf-8");
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT pet_id, nickname, variety_name, birthday, age, sex, colour, personality, health, adopt_state, administrator_id, last_update_time FROM pet, variety WHERE pet.variety_id = variety.variety_id ORDER BY pet_id ASC"; 
    $ret = mysqli_query($conn, $sql_select);

    while ($row = mysqli_fetch_assoc($ret)) { ?>
        <div class="card" id="<?php echo $row['pet_id']?>">
            <div class="content">
                <h2 class="title">#<?php echo $row['pet_id']?> <?php echo $row['nickname']?></h2>
                <p class="info">品种：<?php echo $row['variety_name']?><br>生日：<?php echo $row['birthday']?><br>年龄：<?php echo $row['age']?><br>
                性别：<?php switch ($row['sex']) {
                        case 'M':
                            echo "♂";
                            break;
                        case 'F':
                            echo "♀";
                            break;
                        }?><br>颜色：<?php echo $row['colour']?><br>性格：<?php echo $row['personality']?><br>健康状况：<?php echo $row['health']?><br>
                领养状态：<?php switch ($row['adopt_state']) {
                        case 0:
                            echo "未领养";
                            break;
                        case 1:
                            echo "已领养";
                            break;
                        }?><br>发布人：管理员#<?php echo $row['administrator_id']?><br>最后更新时间：<?php echo $row['last_update_time']?></p>
                <div>
                    <input type="button" class="btn m-left" value="修改" onclick="change('changeModal', <?php echo $row['pet_id']?>)">
                    <input type="button" class="btn m-right" value="删除" id="delete<?php echo $row['pet_id']?>" onclick="deleteDiv(<?php echo $row['pet_id']?>)">
                </div>
            </div>
        </div>
    <?php }
    mysqli_close($conn); //关闭数据库
    ?>
    </main>
    <div id="changeModal" class="modal">
        <h1>修改宠物信息</h1>
        <div class="modal-content">
            <span class="close">&times;</span>
                <?php
                header("Content-Type: text/html;charset=utf-8");
                session_start();
                if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
                    //if (isset($_SESSION['pet'])) {
                      /* $pet = $_SESSION['pet'];
                        $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
                        $sql_select = "SELECT nickname, variety_id, birthday, age, sex, colour, personality, health, adopt_state FROM pet WHERE pet_id = '$pet'"; 
                        $ret = mysqli_query($conn, $sql_select);
                        $row = mysqli_fetch_array($ret); */
                ?>
                    <form id="petchangeform" action="petChange.php" method="post">
                        <label for="input1">昵称：</label>
                        <input type="text" id="nickname" name="nickname"><br>
                        <label for="input2">品种编号：</label>
                        <input type="number" id="variety" min="0" max="20" name="variety"><br>
                        <label for="input3">生日：</label>
                        <input type="date" id="birthday" name="birthday"><br>
                        <label for="input4">年龄：</label>
                        <input type="number" id="age" min="0" max="200" name="age"><br>
                        <label for="input5">性别：</label>
                        <input type="radio" id="sex" name="sex" value="M" style="color: white">♂
                        <input type="radio" id="sex" name="sex" value="F" style="color: white">♀
                        <br>
                        <label for="input6">颜色：</label>
                        <input type="text" id="colour" name="colour"><br>
                        <label for="input7">性格：</label>
                        <input type="text" id="personality" name="personality"><br>
                        <label for="input8">健康状况：</label>
                        <input type="text" id="health" name="health"><br>
                        <label for="input9">领养状态：</label>
                        <input type="radio" id="adopt_state" name="adopt_state" value="0" style="color: white">未领养
                        <input type="radio" id="adopt_state" name="adopt_state" value="1" style="color: white">已领养
                        <br>
                        <div slot="footer">
                            <input type="submit" id="confirm" name="confirm" value="确认" class="btn">
                        </div>
                    </form>
                        <?php /*
                        $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : "";
                        $variety = isset($_POST['variety']) ? $_POST['variety'] : "";
                        $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : "";
                        $age = isset($_POST['age']) ? $_POST['age'] : "";
                        $sex = isset($_POST['sex']) ? $_POST['sex'] : "";
                        $colour = isset($_POST['colour']) ? $_POST['colour'] : "";
                        $personality = isset($_POST['personality']) ? $_POST['personality'] : "";
                        $health = isset($_POST['health']) ? $_POST['health'] : "";
                        $adopt_state = isset($_POST['adopt_state']) ? $_POST['adopt_state'] : "";
                        if ($nickname != $row['nickname'] && $nickname != "") {
                            $sql_update = "UPDATE pet SET nickname = '$nickname' WHERE pet_id = '$pet'";
                            mysqli_query($conn, $sql_update);
                        }
                        if ($variety != $row['variety'] && $variety != "") {
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
                        mysqli_close($conn); //关闭数据库 */
                        //header('location: '.$_SERVER['HTTP_REFERER']); //刷新页面
                    //}
                } else {
                    echo "<script>alert('请先登录！');location='html/login.html'</script>";
                } ?>
        </div>
    </div>
    <div class="float-btn" type="button" onclick="addPet('addModal')">
        <img src="images/add.png" width="40px" height="40px">
    </div>
    <div id="addModal" class="modal">
        <h1>发布新的宠物</h1>
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="petaddform" action="petAdd.php" method="post">
                <label for="input1">昵称：</label>
                <input type="text" id="nickname" name="nickname"><br>
                <label for="input2">品种编号：</label>
                <input type="number" id="variety" min="0" max="20" name="variety"><br>
                <label for="input3">生日：</label>
                <input type="date" id="birthday" name="birthday"><br>
                <label for="input4">年龄：</label>
                <input type="number" id="age" min="0" max="200" name="age"><br>
                <label for="input5">性别：</label>
                <input type="radio" id="sex" name="sex" value="M" style="color: white">♂
                <input type="radio" id="sex" name="sex" value="F" style="color: white">♀
                <br>
                <label for="input6">颜色：</label>
                <input type="text" id="colour" name="colour"><br>
                <label for="input7">性格：</label>
                <input type="text" id="personality" name="personality"><br>
                <label for="input8">健康状况：</label>
                <input type="text" id="health" name="health"><br>
                <label for="input9">领养状态：</label>
                <input type="radio" id="adopt_state" name="adopt_state" value="0" style="color: white">未领养
                <input type="radio" id="adopt_state" name="adopt_state" value="1" style="color: white">已领养
                <br>
                <div slot="footer">
                    <input type="submit" id="confirm" name="confirm" value="确认" class="btn">
                </div>
            </form>
                <?php /*
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
                    $conn = mysqli_connect("localhost:3307", "root", "123456", "pet_adopt"); //连接数据库
                    mysqli_set_charset($conn,"utf8");
                    $sql_select = "SELECT administrator_id FROM administrator WHERE account = '$account'";
                    $ret = mysqli_query($conn, $sql_select);
                    $row = mysqli_fetch_array($ret);
                    $administrator = $row['administrator_id'];
                    $sql_insert = "INSERT INTO pet(variety_id, administrator_id, nickname, birthday, age, sex, colour, personality, health, adopt_state, last_update_time)
                    VALUES('$variety', '$administrator', '$nickname', '$birthday', '$age', '$sex', '$colour', '$personality', '$health', '$adopt_state', NOW())";
                    mysqli_query($conn, $sql_insert);
                    mysqli_close($conn); //关闭数据库
                    //header('location: '.$_SERVER['HTTP_REFERER']); //刷新页面
                } else {
                    echo "<script>alert('请先登录！');location='html/login.html'</script>";
                } */ ?>
            </form>
        </div>
    </div>
                            
    <script type="text/javascript">
        function change(id, pet) {
            // 打开模态框
            var mo = document.getElementById(id);
            mo.style.display = "block";
            $("#confirm").attr("disabled", true);
            $.ajax({
                type:"POST",
                url:"ID.php",
                data:{pet:pet},
                success:function(msg) {
                    $("#confirm").attr("disabled", false);
                },
                error:function(msg) {
                    $("#confirm").attr("disabled", false);
                }
            });
        }

        function deleteDiv(pet) {
            $.ajax({
                type:"POST",
                url:"petDelete.php",
                data:{pet:pet}
            });
            window.location.reload();
        }

        function addPet(id) {
            var mo = document.getElementById(id);
            mo.style.display = "block";
        }
    </script>
</body>
</html>
