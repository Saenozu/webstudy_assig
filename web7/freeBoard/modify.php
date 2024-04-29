<?php
    include('./config.php');
    include('./db.php');
    include('./filter.php');

    if (!isset($_SESSION['is_login'])) {
        echo "<meta http-equiv='refresh' content='0;url=./''>";
    }

    if(!eregi(getenv("HTTP_HOST"),getenv("HTTP_REFERER"))) {
        echo "<script> alert(\"올바른 경로로 접근해주세요.\");history.go(-1);</script>";
        exit;
    }

    $con_no = intval($_GET['no']);

    $query = "SELECT * FROM FreeBoard_Post WHERE no=$con_no";
    if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
        $row = mysqli_fetch_array($result);
        $m_title = $row['title'];
        $m_content = $row['content'];
        $m_date = strtotime(strval($row['date']));
        $m_date = date("Y-m-d H:i", $m_date);
        $m_file = $row['file'];
        $m_lock_flag = $row['lock_flag'];
        $m_pw = $row['pw'];
    }
    else {
        echo "<script>alert('잘못된 접근입니다.'); location.href='./';</script>";
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
                                        <td class='edit_input' colspan='3'><input type='text' name='title' placeholder='제목을 입력해주세요' maxlength='30' value='<?php echo $m_title; ?>'/></td>
                                    </tr>
                                    <tr>
                                        <td class='edit_table_head'>비밀글</td>
                                        <td class='edit_input'>
                                            <input type='checkbox' id='edit_input_cb' name='locked' onclick='lock_post(event)' value='1'
                                            <?php if ($m_lock_flag) {echo "checked='checked'";} ?>/>
                                        </td>
                                        <td class='edit_table_head pw disable'>비밀번호</td>
                                        <td class='edit_input pw disable'><input type='text' name='pw' placeholder='비밀번호를 입력해주세요' maxlength='20' onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'');"  value='<?php echo $m_pw; ?>'/></td>
                                    </tr>
                                    <tr><td colspan='4' class='edit_content_head'>내용</td></tr>
                                    <tr>
                                        <td colspan='4' class='edit_content'>
                                            <textarea name='content' cols='80' rows='25' wrap='hard' placeholder='내용을 입력해주세요' maxlength='1500'><?php echo $m_content; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='edit_table_head'>파일</td>
                                        <td width='77px' class='edit_input'>
                                            <input type='file' id='edit_input_file' onchange='print_current_file()' name='uploadfile'/>
                                            <label for='edit_input_file'>파일 선택</label>
                                        </td>
                                        <td colspan='2' class='edit_input' style='border-left: 1px solid #BFCDD9;'>
                                            <p id='print_file_name'><?php 
                                                echo "<script>document.getElementById('print_file_name').style.display='none';</script>";
                                                if ($m_file){
                                                    echo "<script>document.getElementById('print_file_name').style.display='inline-block';</script>";
                                                    if ($m_file) {echo $m_file;}
                                                }
                                            ?></p>
                                            <input type='checkbox' id='remove_file' onclick='delete_file(event)' name='del_file' value='1' style='display:none;'/>
                                            <label for='remove_file'>삭제</label>
                                        </td>
                                    </tr>
                                </table>
                                <div class='btn_wrap'>
                                    <button type='submit' class='btn_submit' name='modify_save' value='1'>
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
        var flag = 0;
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
        /* 비밀번호 표시 */
        var checkbox = document.getElementById('edit_input_cb');
        if (checkbox.checked) {
            document.getElementsByClassName('pw')[0].classList.remove('disable');
            document.getElementsByClassName('pw')[1].classList.remove('disable');
        }
        /* 현재 선택된 파일 출력 */
        function print_current_file() {
            if (document.getElementById('edit_input_file').files[0]) {
                var file = document.getElementById('edit_input_file').files[0]
                var file_name = file.name;
                document.getElementById('print_file_name').innerHTML = file_name;
                document.getElementById('print_file_name').style.display='inline-block';
                console.log('Success', file_name);
            }
        }
        function delete_file(event) {
            if (event.target.checked) {
                document.getElementById('edit_input_file').value = '';
                document.getElementById('print_file_name').style.display='none';
            } else {
                document.getElementById('remove_file').checked = true;
            }
        }
    </script>
</html>
<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!($_POST['title'])) {
            echo "<script>alert('제목을 입력해주세요.'); location.href=location.href+'?no=$con_no';</script>";
        }
        else if (!($_POST['content'])) {
            echo "<script>alert('내용을 입력해주세요.'); location.href=location.href+'?no=$con_no';</script>";
        }
        else {
            if ($_FILES['uploadfile']['size'] == 0) {
                if ($_POST['del_file']) {
                    $query = "SELECT file FROM FreeBoard_Post WHERE no=$con_no";
                    if(mysqli_num_rows($result = mysqli_query($conn, $query))) {
                        $row = mysqli_fetch_array($result);
                        unlink('./WkZoQ2MySXlSbXM9/'.$row['file']);
                        $query = "UPDATE FreeBoard_Post SET file=NULL WHERE no=$con_no";
                        if(mysqli_query($conn, $query)) {
                        }
                    }
                }
                if ($_POST['locked']) {

                    $query = "UPDATE FreeBoard_Post SET title=\"".$_POST['title']."\", content=\"".$_POST['content']."\", pw=\"".$_POST['pw']."\", lock_flag=1 WHERE no=$con_no";
                    if ($result = mysqli_query($conn, $query)) {
                        echo "<script>location.href='./?type=post&no=$con_no';</script>";
                    } else {
                        echo "<script>alert('저장을 실패했습니다.'); location.href=location.href+'?no=$con_no';</script>";
                    }
                } else {
                    $query = "UPDATE FreeBoard_Post SET title=\"".$_POST['title']."\", content=\"".$_POST['content']."\", pw=NULL, lock_flag=0 WHERE no=$con_no";
                    if ($result = mysqli_query($conn, $query)) {
                        echo "<script>location.href='./?type=post&no=$con_no';</script>";
                    } else {
                        echo "<script>alert('저장을 실패했습니다.'); location.href=location.href+'?no=$con_no';</script>";
                    }
                }
            } else {
                $file = $_FILES['uploadfile'];
                $file_name = round(microtime(true)) . "_" .$file['name'];
                $file_tmp = $file['tmp_name'];
                $path = "./WkZoQ2MySXlSbXM9/";

                if (move_uploaded_file($file_tmp,$path.$file_name)){
                    if ($_POST['locked']) {
                        $query = "UPDATE FreeBoard_Post SET title=\"".$_POST['title']."\", content=\"".$_POST['content']."\", file=\"$file_name\", pw=\"".$_POST['pw']."\", lock_flag=1 WHERE no=$con_no";
                        if ($result = mysqli_query($conn, $query)) {
                            echo "<script>location.href='./?type=post&no=$con_no';</script>";
                        } else {
                            echo "<script>alert('저장을 실패했습니다.'); location.href=location.href+'?no=$con_no';</script>";
                        }
                    } else {
                        $query = "UPDATE FreeBoard_Post SET title=\"".$_POST['title']."\", content=\"".$_POST['content']."\", file=\"$file_name\", pw=NULL, lock_flag=0 WHERE no=$con_no";
                        if ($result = mysqli_query($conn, $query)) {
                            echo "<script>location.href='./?type=post&no=$con_no';</script>";
                        } else {
                            echo "<script>alert('저장을 실패했습니다.'); location.href=location.href+'?no=$con_no';</script>";
                        }
                    }
                }
                
            }
        }
    }
?>