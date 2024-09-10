<!DOCTYPE html>
<html>
<head>
    <title>主页</title>
    <link rel="stylesheet" href="css/index.css" type="text/css" media="all">
    <script src="js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
    <div class="loader"></div>
    <div class="header">
        <a href="index.php" class="logo">
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
    <div class="main-top">
        <div class="main-banner">
            <div class="style-banner ">
                <h4 class="mb-2">宠物</h4>
                <h5>是我们最忠实的伙伴</h5>
            </div>
            <div class="description mt-md-4 mt-3">
                <p>“He is only your dog, but you are his whole life.”</p>
            </div>
            <div class="end-banner">
                <p>用领养代替购买，给它们一个温暖的家 🡣</p>
            </div>
        </div>
    </div>
    <div><br><br></div>
    <main class="page-content">
    <?php 
    header("Content-Type: text/html;charset=utf-8");
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); 
    $sql_select = "SELECT pet_id, nickname, variety_name, birthday, age, sex, colour, personality, health, photo_path FROM pet, variety WHERE pet.variety_id = variety.variety_id AND adopt_state = '0' ORDER BY pet_id ASC"; //连接数据库
    $ret = mysqli_query($conn, $sql_select);
    
    while ($row = mysqli_fetch_assoc($ret)) { ?>
        <div class="card" style="background-image: url(<?php echo $row['photo_path']?>)">
            <div class="content">
                <h2 class="title">No.<?php echo $row['pet_id']?> <?php echo $row['nickname']?></h2>
                <p class="info">品种：<?php echo $row['variety_name']?><br>生日：<?php echo $row['birthday']?><br>年龄：<?php echo $row['age']?><br>
                性别：<?php switch ($row['sex']) {
                        case 'M':
                            echo "♂";
                            break;
                        case 'F':
                            echo "♀";
                            break;
                        }?><br>颜色：<?php echo $row['colour']?><br>性格：<?php echo $row['personality']?><br>健康状况：<?php echo $row['health']?><br></p>
                <button type="button" class="btn" onclick="showPrompt(<?php echo $row['pet_id']?>)">申请</button>
            </div>
        </div>
    <?php }
    mysqli_close($conn); //关闭数据库
    ?> 
    </main>
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <h1>请核对您的个人信息</h1>
            <span class="close" onclick="cancel('infoModal')">&times;</span>
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
                <form id="changeform" action="apply.php" method="post">
                    <label for="input1">姓名：</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['full_name']?>"><br>
                    <label for="input2">年龄：</label>
                    <input type="number" id="age" min="0" max="120" name="age" value="<?php echo $row['age']?>"><br>
                    <label for="input3">性别：</label>
                    <input type="radio" name="sex" value="M" style="color: white">♂
                    <input type="radio" name="sex" value="F" style="color: white">♀
                    <?php if ($row['sex'] == "M") {
                        echo "<script>$('input:radio:first').attr('checked', 'true');</script>";
                    } else {
                        echo "<script>$('input:radio:last').attr('checked', 'true');</script>";
                    } ?>
                    <br>
                    <label for="input4">电话：</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $row['phone']?>"><br>
                    <label for="input5">邮箱：</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']?>"><br>
                    <label for="input6">地址：</label>
                    <input type="text" id="address" name="address" value="<?php echo $row['personal_address']?>"><br>
                    <div slot="footer">
                        <input type="submit" id="apply_confirm" name="confirm" value="确认" class="modal_btn">
                    </div>
                </form>
                <?php 
                } else {
                    echo "<script>alert('请先登录！');location='html/login.html'</script>";
                } ?>
        </div>
    </div>  
    <div id="drawerRight">
        <div class="icon" onclick="expand()">品种大全</div>
        <span class="close" onclick="restore()">&times;</span>
        <dl class="stack">
            <?php 
            $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
            $sql_select = "SELECT variety_id, variety_name, introduction FROM variety"; 
            $ret = mysqli_query($conn, $sql_select);
            while ($row = mysqli_fetch_assoc($ret)) { ?>
                <dt>#<?php echo $row['variety_id']?>  <?php echo $row['variety_name']?></dt>
                <dd><?php echo $row['introduction']?></dd>
            <?php }
            mysqli_close($conn); //关闭数据库
            ?>
        </dl>
    </div>
    <div class="mask"></div>

    <script type="text/javascript">
        /*--------- Loader ----------*/
        $(window).on("load", function () {
            $('.loader').fadeOut(1500, function () {
                $(this).remove();
            });
        });
        
        function showPrompt(pet) {
            // 清空上一次提交的表单数据
            document.getElementById("changeform").reset();
            // 打开模态框
            var mo = document.getElementById("infoModal");
            mo.style.display = "flex";
            document.body.style.overflow = "hidden";
            $.ajax({
                type:"POST",
                url:"getPetID.php",
                data:{pet:pet}
            });
        }

        function cancel(id) {
            // 关闭模态框
            var mo = document.getElementById(id);
            mo.style.display = "none";
            if (document.querySelector(".mask").style.display != "block") {
                document.body.style.overflow = "auto";
            }
        }

        function expand() {
            var drawer = document.getElementById("drawerRight");
            var mask = document.querySelector(".mask");
            drawer.style.right = "0";
            mask.style.display = "block";
            document.body.style.overflow = "hidden";
        }
        
        $('.mask').bind('click', function(event) {
            debugger;
            event.stopPropagation();
            // IE支持 event.srcElement，FF支持 event.target
            var evt = event.srcElement ? event.srcElement : event.target;
            if (evt.className != 'mask') {
                return;
            } else {
                debugger;
                var drawer = document.getElementById("drawerRight");
                var mask = document.querySelector(".mask");
                drawer.style.right = "-33.5%";
                mask.style.display = "none";
                document.body.style.overflow = "auto";
            }
        });

        function restore() {
            debugger;
            var drawer = document.getElementById("drawerRight");
            var mask = document.querySelector(".mask");
            drawer.style.right = "-33.5%";
            mask.style.display = "none";
            document.body.style.overflow = "auto";
        }

        /**function fillInfo() {
            <?php 
            /**header("Content-Type: text/html;charset=utf-8");
            if (isset($_SESSION['user'])) {
                $account = $_SESSION['user'];
                $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
                $sql_select = "SELECT full_name, age, sex, phone, email, personal_address FROM common_user WHERE account = '$account'"; 
                $ret = mysqli_query($conn, $sql_select);
                $row = mysqli_fetch_array($ret);
                ?>
                var name = prompt("name: ", "<?php echo $row['full_name']?>");
                var age = prompt("age", "<?php echo $row['age']?>");
                var sex = prompt("sex", "<?php echo $row['sex']?>");
                var phone = prompt("phone", "<?php echo $row['phone']?>");
                var email = prompt("email", "<?php echo $row['email']?>");
                var personal_address = prompt("address", "<?php echo $row['personal_address']?>");
                <?php
                mysqli_close($conn); //关闭数据库
            } else {
                echo "<script>alert('请先登录！');location='html/login.html'</script>";
            }*/ ?>
        }*/
    </script>
</body>
</html>
