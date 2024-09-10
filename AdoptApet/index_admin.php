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
        <a href="index_admin.php" class="logo">
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
    <div><br></div>
    <main class="page-content">
    <?php
    ob_start();
    header("Content-Type: text/html;charset=utf-8");
    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
    $sql_select = "SELECT pet_id, nickname, variety_name, birthday, age, sex, colour, personality, health, photo_path, adopt_state, pet.administrator_id, last_update_time FROM pet, variety WHERE pet.variety_id = variety.variety_id ORDER BY pet_id ASC"; 
    $ret = mysqli_query($conn, $sql_select);

    while ($row = mysqli_fetch_assoc($ret)) { ?>
        <div class="card" id="pet<?php echo $row['pet_id']?>" style="background-image: url(<?php echo $row['photo_path']?>)">
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
                    <input type="button" class="btn m-left" value="修改" onclick="change(<?php echo $row['pet_id']?>)">
                    <input type="button" class="btn m-right" value="删除" id="delete<?php echo $row['pet_id']?>" onclick="deleteDiv(<?php echo $row['pet_id']?>)">
                </div>
            </div>
        </div>
    <?php }
    mysqli_close($conn); //关闭数据库
    ?>
    </main>
    <div id="changeModal" class="modal">
        <div class="modal-content">
            <h1>修改宠物信息</h1>
            <span class="close" onclick="cancel('changeModal')">&times;</span>
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
                    $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
                    $sql_select = "SELECT variety_id, variety_name FROM variety"; 
                    $ret = mysqli_query($conn, $sql_select);
                ?>
                    <form id="petchangeform" action="petChange.php" method="post" enctype="multipart/form-data">
                        <label for="input1">昵称：</label>
                        <input type="text" name="nickname"><br>
                        <label for="input2">品种：</label>
                        <select title="pet_variety" name="variety">
                            <option value="" selected disabled hidden>请选择选项</option>
                            <?php while ($row = mysqli_fetch_assoc($ret)) { ?>
                            <option value="<?php echo $row['variety_id']?>"><?php echo $row['variety_name']?></option>
                            <?php } ?>
                        </select><br>
                        <label for="input3">生日：</label>
                        <input type="date" name="birthday" value="2024-01-01"><br>
                        <label for="input4">年龄：</label>
                        <input type="number" min="0" max="200" name="age"><br>
                        <label for="input5">性别：</label>
                        <input type="radio" name="sex" value="M" style="color: white">♂
                        <input type="radio" name="sex" value="F" style="color: white">♀
                        <br>
                        <label for="input6">颜色：</label>
                        <input type="text" name="colour"><br>
                        <label for="input7">性格：</label>
                        <input type="text" name="personality"><br>
                        <label for="input8">健康状况：</label>
                        <input type="text" name="health"><br>
                        <label for="input9">领养状态：</label>
                        <input type="radio" name="adopt_state" value="0" style="color: white">未领养
                        <input type="radio" name="adopt_state" value="1" style="color: white">已领养
                        <br>
                        <div style="position: relative">
                            <input type="file" id="change_upload" class="upload-input" name="photo" accept="image/jpg, image/png, image/gif" onchange="showImg(this, 'upload1')"> <!-- 只接受jpg，png和gif格式 -->
                            <span type="text" style="vertical-align: middle">上传照片：</span>
                            <img id="upload1" src="images/upload.png" alt="upload_icon" width="18px" height="18px" style="vertical-align: middle" onclick="upload('change_upload')">
                        </div>
                        <div slot="footer">
                            <input type="submit" id="change_confirm" name="confirm" value="确认" class="modal_btn">
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
    <div class="float-btn" type="button" onclick="addPet()">
        <img src="images/add.png" alt="add_icon" width="40px" height="40px">
    </div>
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h1>发布新的宠物</h1>
            <span class="close" onclick="cancel('addModal')">&times;</span>
            <?php
            header("Content-Type: text/html;charset=utf-8");
            session_start();
            if (isset($_SESSION['user']) && $_SESSION['role'] == 1) {
                $conn = mysqli_connect('localhost:3307', 'root', '123456', 'pet_adopt'); //连接数据库
                $sql_select = "SELECT variety_id, variety_name FROM variety"; 
                $ret = mysqli_query($conn, $sql_select);
            ?>
                <form id="petaddform" action="petAdd.php" method="post" enctype="multipart/form-data">
                    <label for="input1">昵称：</label>
                    <input type="text" name="nickname" required="required"><br>
                    <label for="input2">品种：</label>
                    <select title="pet_variety" name="variety" required="required">
                        <option value="" selected disabled hidden>请选择选项</option>
                        <?php while ($row = mysqli_fetch_assoc($ret)) { ?>
                        <option value="<?php echo $row['variety_id']?>"><?php echo $row['variety_name']?></option>
                        <?php } ?>
                    </select><br>
                    <label for="input3">生日：</label>
                    <input type="date" name="birthday" value="2024-01-01"><br>
                    <label for="input4">年龄：</label>
                    <input type="number" min="0" max="200" name="age"><br>
                    <label for="input5">性别：</label>
                    <input type="radio" name="sex" value="M" style="color: white" required="required">♂
                    <input type="radio" name="sex" value="F" style="color: white" required="required">♀
                    <br>
                    <label for="input6">颜色：</label>
                    <input type="text" name="colour" required="required"><br>
                    <label for="input7">性格：</label>
                    <input type="text" name="personality"><br>
                    <label for="input8">健康状况：</label>
                    <input type="text" name="health"><br>
                    <label for="input9">领养状态：</label>
                    <input type="radio" name="adopt_state" value="0" style="color: white" required="required">未领养
                    <input type="radio" name="adopt_state" value="1" style="color: white" required="required">已领养
                    <br>
                    <div style="position: relative">
                        <input type="file" id="add_upload" class="upload-input" name="photo" accept="image/jpg, image/png, image/gif" onchange="showImg(this, 'upload2')"> <!-- 只接受jpg，png和gif格式 -->
                        <span type="text" style="vertical-align: middle">上传照片：</span>
                        <img id="upload2" src="images/upload.png" alt="upload_icon" width="18px" height="18px" style="vertical-align: middle" onclick="upload('add_upload')">
                    </div>
                    <div slot="footer">
                        <input type="submit" id="add_confirm" name="confirm" value="确认" class="modal_btn">
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
            <button type="button" class="btn1" onclick="addVariety()">新增</button>
        </dl>
    </div>
    <div id="addModal_variety" class="modal">
        <div class="modal-content">
            <h1>新增宠物种类</h1>
            <span class="close" onclick="cancel('addModal_variety')">&times;</span>
            <form id="varietyaddform" action="varietyAdd.php" method="post">
                <label>种类名称：
                    <input type="text" name="variety_name" required="required">
                </label><br>
                <label id="intro">种类介绍：
                    <textarea name="introduction" cols="30" rows="10" placeholder="不超过200字"></textarea>
                </label>
                <div slot="footer">
                    <input type="submit" id="add_confirm" name="confirm" value="确认" class="modal_btn">
                </div>
            </form>
        </div>
    </div>
    <div class="mask"></div>
                            
    <script type="text/javascript">
        /*--------- Loader ----------*/
        $(window).on("load", function () {
            $('.loader').fadeOut(1500, function () {
                $(this).remove();
            });
        });

        function change(pet) {
            // 清空上一次提交的表单数据
            document.getElementById("petchangeform").reset();
            // 打开模态框
            var mo = document.getElementById("changeModal");
            mo.style.display = "flex";
            document.body.style.overflow = "hidden";
            $("#change_confirm").attr("disabled", true);
            $.ajax({
                type:"POST",
                url:"getPetID.php",
                data:{pet:pet},
                success:function(msg) {
                    $("#change_confirm").attr("disabled", false);
                },
                error:function(msg) {
                    $("#change_confirm").attr("disabled", false);
                }
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

        function deleteDiv(pet) {
            $.ajax({
                type: "POST",
                url: "petDelete.php",
                data: {pet:pet}
            });
            window.location.reload();
        }

        function addPet() {
            // 清空上一次提交的表单数据
            document.getElementById("petaddform").reset();
            // 打开模态框
            var mo = document.getElementById("addModal");
            mo.style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function upload(id) {
            var up = document.getElementById(id);
            up.click();
        }

        function showImg(input, id) {
            var file = input.files[0];
            var reader = new FileReader()
            // 图片读取成功回调函数
            reader.onload = function(e) {
                document.getElementById(id).src=e.target.result
            }
            reader.readAsDataURL(file)
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

        function addVariety() {
            // 清空上一次提交的表单数据
            document.getElementById("varietyaddform").reset();
            // 打开模态框
            var mo = document.getElementById("addModal_variety");
            mo.style.display = "block";
        }

    </script>
</body>
</html>
