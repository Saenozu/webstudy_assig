<?php
    include('./config.php');
    include('./db.php');
    include('./filter.php');

    if (!isset($_SESSION['is_login'])) {
        echo "<meta http-equiv='refresh' content='0;url=./''>";
    }
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
	<title> 2022 자유게시판 </title>
	<link href="style" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="#">
</head>
    <body>
        <div id="wrap">
            <div id="header">
                <div class="header_side"></div>
                <div class="header_center"><a href='./' id="header_title">2022 SAENOZU FREEBOARD</a></div>
                <div class="header_side">
                    <?php
                        if ($_SESSION['is_login']) {
                            echo "<a href='profile.php' class='link_login'>".$_SESSION['user_name']."&nbsp;님</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                            echo "<a href='logout.php' class='link_login'> LOGOUT </a>";
                        }
                        else { echo "<a href='login.php' class='link_login'> LOGIN </a>"; }
                    ?>
                </div>
            </div>
            <div id='contents'>
                <div id='contents_wrap'>
                    <div id='post_wrap'>
                        <!--post edit(S)-->
                        <div id='post_edit_wrap'>
                            <form id='post_edit_form' method='post' action='' enctype='multipart/form-data'>
                                <table id='post_edit_table'>
                                    <tr>
                                        <td class='edit_table_head'>제목</td>
                                        <td class='edit_input' colspan='3'><input type='text' name='title' placeholder='제목을 입력해주세요' maxlength='30'/></td>
                                    </tr>
                                    <tr>
                                        <td class='edit_table_head'>비밀글</td>
                                        <td class='edit_input'><input type='checkbox' name='locked' onclick='lock_post(event)' value='1'/></td>
                                        <td class='edit_table_head pw disable'>비밀번호</td>
                                        <td class='edit_input pw disable'><input type='text' name='pw' placeholder='비밀번호를 입력해주세요' maxlength='20' onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'');"/></td>
                                    </tr>
                                    <tr><td colspan='4' class='edit_content_head'>내용</td></tr>
                                    <tr><td colspan='4' class='edit_content'><textarea name='content' wrap='hard' cols='80' rows='25' placeholder='내용을 입력해주세요' maxlength='1500'></textarea></td></tr>
                                    <tr>
                                        <td class='edit_table_head'>파일</td>
                                        <td class='edit_input' colspan='3'><input type='file' name='uploadfile'/></td>
                                    </tr>
                                </table>
                                <div class='btn_wrap'>
                                    <button type='submit' class='btn_submit'>
                                        <span class='btn_text'>저장</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--post edit(E)-->	
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        /* 한글입력 방지 */
        function check_hangeul() {
            $("input[name=p_email_id]").keyup(function(event){
                if (!(event.keyCode >=37 && event.keyCode<=40)) {
                    var inputVal = $(this).val();
                    $(this).val(inputVal.replace(/[^a-z0-9^]/gi,''));
                }
            });

            $("input[name=p_email_site]").keyup(function(event){
                if (!(event.keyCode >=37 && event.keyCode<=40)) {
                    var inputVal = $(this).val();
                    $(this).val(inputVal.replace(/[^a-z.0-9]/gi,''));
                }
            });
        }
        /* 비밀번호 표시|숨김 */
        function lock_post(event) {
            if (event.target.checked) {
                document.getElementsByClassName('pw')[0].classList.remove('disable');
                document.getElementsByClassName('pw')[1].classList.remove('disable');
            } else {
                document.getElementsByClassName('pw')[0].classList.add('disable');
                document.getElementsByClassName('pw')[1].classList.add('disable');
            }
        } 
    </script>
</html>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!($_POST['title'])) {
            echo ("<script>alert('제목을 입력해주세요.'); location.href=location.href;</script>");
        }
        else if (!($_POST['content'])) {
            echo ("<script>alert('내용을 입력해주세요.'); location.href=location.href;</script>");
        }
        else {
            if ($_FILES['uploadfile']['size'] == 0) {
                if ($_POST['locked']) {
                    $query = "INSERT INTO FreeBoard_Post(user, title, content, pw, lock_flag) VALUES (\"$login_name\", \"".$_POST['title']."\", \"".$_POST['content']."\", \"".$_POST['pw']."\", 1)";
                    if ($result = mysqli_query($conn, $query))
                        echo "<script>location.href='./';</script>";
                    else
                        echo "<script>location.href=location.href;</script>";
                } else {
                    $query = "INSERT INTO FreeBoard_Post(user, title, content) VALUES (\"$login_name\", \"".$_POST['title']."\", \"".$_POST['content']."\")";
                    if ($result = mysqli_query($conn, $query))
                        echo "<script>location.href='./';</script>";
                    else
                        echo "<script>location.href=location.href;</script>";
                }
            } else {
                $file = $_FILES['uploadfile'];
                $file_name = round(microtime(true)) . "_" .$file['name'];
                $file_tmp = $file['tmp_name'];
                $path = "./WkZoQ2MySXlSbXM9/";

                if (move_uploaded_file($file_tmp,$path.$file_name)){
                    if ($_POST['locked']) {
                        $query = "INSERT INTO FreeBoard_Post(user, title, content, file, pw, lock_flag) VALUES (\"$login_name\", \"".$_POST['title']."\", \"".$_POST['content']."\", \"$file_name\", \"".$_POST['pw']."\", 1)";
                        if ($result = mysqli_query($conn, $query))
                        echo "<script>location.href='./';</script>";
                    else
                        echo "<script>location.href=location.href;</script>";
                    } else {
                        $query = "INSERT INTO FreeBoard_Post(user, title, content, file) VALUES (\"$login_name\", \"".$_POST['title']."\", \"".$_POST['content']."\", \"$file_name\")";
                        if ($result = mysqli_query($conn, $query))
                        echo "<script>location.href='./';</script>";
                    else
                        echo "<script>location.href=location.href;</script>";
                    }
                }
            }
            if (isset($_GET['no'])) {
                $con_no = intval($_GET['no']);
                $query = "SELECT * FROM FreeBoard_Post WHERE no=$con_no";
                mysqli_num_rows($result = mysqli_query($conn, $query));
                $row = mysqli_fetch_array($result);
                $con_depth = $row['depth'];
                $re_no = $row['re_no'];
                $next_depth = $con_depth+1;
                $depth_query = "UPDATE FreeBoard_Post SET depth=$next_depth, re_no=$re_no ORDER BY no DESC LIMIT 1";
                mysqli_query($conn, $depth_query);
                echo "<script>location.href='./';</script>";
            } else {
                $depth_query = "UPDATE FreeBoard_Post SET re_no=no ORDER BY no DESC LIMIT 1";
                mysqli_query($conn, $depth_query);
                echo "<script>location.href=location.href;</script>";
            }
        }
    }
?>