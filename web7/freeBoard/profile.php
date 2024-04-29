<?php
include('./config.php');
include('./db.php');

if (!isset($_SESSION['is_login'])) {
    echo "<meta http-equiv='refresh' content='0;url=./''>";
}

$query = "SELECT * FROM FreeBoard_Account WHERE id='$login_id'";
    if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
        $row = mysqli_fetch_array($result);
        $user_id = $login_id;
        $user_name = $login_name;
        $user_pw = $row['password'];
        $user_email = $row['email'];
    }
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
	<title> 2022 자유게시판 </title>
	<style>
		#profile_wrap {
            border: 1px solid #BFCDD9;
            padding: 29px 68px;
            }
        #profile_table {
            border: 0;
        }
        #profile_table td {
            padding: 15px;
        }
        #notice {
            display: none;
            color: #E25345;
        }
        .profile_input {
            width: 60%;
            border: 1px solid #011640;
            padding: 5px;
        }
	</style>
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
                    <?php
                        include('pw_check.php');
                        if ($user_pw == $pw_try||$_GET['mode']=='modify'||$_GET['mode']=='remove') {
                            echo "<script>document.getElementById('post_check_wrap').classList.add('disable'); </script>";
                        
                    ?>
                    <div id='profile_wrap'>
                        <table id='profile_table'>
                            <?php
                            if (empty($_GET['mode'])) { ?>
                            <form method='get' action=''>
                                <!--id(S)-->
                                <tr><td>아이디</td><td><?php echo $user_id; ?></td></tr>
                                <!--id(E)-->
                                <!--name(S)-->
                                <tr><td>이름</td><td><?php echo $user_name; ?></td></tr>
                                <!--name(E)-->
                                <!--email(S)-->
                                <tr><td>이메일</td><td><?php echo $user_email; ?></td></tr>
                                <!--email(E)-->
                                <!--buttons(S)-->
                                <tr>
                                    <td colspan='2'>
                                        <button type='submit' class='btn_submit' name='mode' value='modify' style='margin-right: 15px;'>
                                            <span class='btn_text'>수정</span>
                                        </button>
                                        <button type='submit' class='btn_submit' name='mode' value='remove' onclick="if(!check_to_drop()){return false;}" style='background-color: #E25345;'>
                                            <span class='btn_text'>탈퇴</span>
                                        </button>
                                    </td>
                                </tr>
                                <!--buttons(E)-->
                            </form>
                            <?php } else if ($_GET['mode']=='modify') { ?>
                                <form method='post' action=''>
                                <!--id(S)-->
                                <tr>
                                    <td>아이디</td>
                                    <td>
                                        <?php echo $user_id; ?>
                                    </td>
                                </tr>
                                <!--id(E)-->
                                <!--name(S)-->
                                <tr>
                                    <td>이름</td>
                                    <td>
                                        <input type='text' class='profile_input' name='change_name' value='<?php echo $user_name; ?>'/>
                                    </td>
                                </tr>
                                <!--name(E)-->
                                <!--pw(S)-->
                                <tr>
                                    <td>비밀번호</td>
                                    <td>
                                        <input type='password' class='profile_input' name='change_pw'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>비밀번호 확인</td>
                                    <td>
                                        <input type='password' class='profile_input' name='change_pw_check'/>
                                    </td>
                                </tr>
                                <!--pw(E)-->
                                <!--email(S)-->
                                <tr>
                                    <td>이메일</td>
                                    <td>
                                        <input type='text' class='profile_input' name='change_email' value='<?php echo $user_email; ?>'/>
                                    </td>
                                </tr>
                                <!--email(E)-->
                                <!--notice(S)-->
                                <tr>
                                    <td id='notice' colspan='2'></td>
                                </tr>
                                <!--notice(E)-->
                                <!--buttons(S)-->
                                <tr>
                                    <td colspan='2'>
                                        <button type='submit' class='btn_submit' name='modify_submit'>
                                            <span class='btn_text'>수정</span>
                                        </button>
                                    </td>
                                </tr>
                                <!--buttons(E)-->
                            </form>
                            <?php
                            } else if ($_GET['mode']=='remove') { 
                                if ($login_id == "admin0") {
                                    echo "<script>alert('관리자 계정은 탈퇴할 수 없습니다.');</script>";
                                } else {
                                    $delete_query = "
                                        DELETE FROM FreeBoard_Account WHERE id='$login_id';
                                        UPDATE FreeBoard_Post SET user='---' WHERE user='$login_name';
                                        UPDATE FreeBoard_Reply SET r_user='---' WHERE r_user='$login_name';
                                        UPDATE FreeBoard_Likes SET uid='*$login_no*' WHERE uid='$login_id';
                                    ";
                                    $result = mysqli_query($conn,$delete_query);
                                    require_once('./logout.php');
                                }
                            } ?>
                        </table>
                            
                        
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var notice=document.getElementById('notice');

    function check_to_drop() {
        if (confirm('탈퇴하시면 복구할 수 없습니다.\n정말로 탈퇴하시겠습니까?')){
            return true;
        } else {
            return false;
        }
    }
<?php
$input_name = mysqli_real_escape_string($_POST['change_name']);
$input_email = mysqli_real_escape_string($_POST['change_email']);
$input_pw = mysqli_real_escape_string($_POST['change_pw']);
$input_pw_check = mysqli_real_escape_string($_POST['change_pw_check']);


function ereg_id($input) {
    if (ereg("^[A-Za-z0-9_\-]{6,15}$",$input)) { return 1; }
    else { return 0; }
}
function ereg_pass($input) {
    if (ereg("^[A-Za-z0-9~!@#%\$\-\+\*]{8,20}$",$input)) { return 1; }
    else { return 0; }
}
function ereg_name($input) {
    if (ereg("^[ㄱ-ㅎ가-힣a-zA-Z0-9]{1,30}$",$input)) { return 1; }
    else { return 0; }
}
function ereg_email($input) {
    if (ereg("^[A-Za-z0-9_\-]{1,64}@[[:alnum:]_\-]+\.(([A-Za-z]{2,3})|([A-Za-z]{2,3}\.[A-Za-z]{2,3}))$",$input)) { return 1; }
    else { return 0; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!ereg_name($input_name)) {
        echo "notice.innerHTML='이름은 1~10자 이내로 입력하셔야 합니다.';";
        echo "notice.style.display='';";
    }
    else if(!ereg_pass($input_pw) && (empty($input_pw) == 0)) { //비밀번호 칸 비어있으면 유지
        echo "notice.innerHTML='비밀번호는 8~20자의 영문, 숫자, 특수기호( ~, !, @, #, $, %, *, + )만 사용 가능합니다.';";
        echo "notice.style.display='';";
    }
    else if(!ereg_email($input_email)) {
        echo "notice.innerHTML='이메일 형식이 올바르지 않습니다.';";
        echo "notice.style.display='';";
    }
    if (ereg_email($input_email)) {
        //중복 판별
        $query = "SELECT * FROM FreeBoard_Account WHERE email='$input_email'";
        if (mysqli_num_rows($result = mysqli_query($conn, $query))) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row['Email'] == $input_email && ($row['id'] != $login_id)) {
                    echo "notice.innerHTML='이미 존재하는 이메일입니다.';";
                    echo "notice.style.display='';";
                }
                else if ($input_pw != $input_pw_check) {
                    echo "notice.innerHTML='비밀번호와 확인 비밀번호가 일치하지 않습니다.';";
                    echo "notice.style.display='';";
                }
            }
        }
        else {
            if (empty($input_pw)) {
                $query = "UPDATE FreeBoard_Account SET name='$input_name', email='$input_email' WHERE id='$login_id'";
            } else {
                $query = "UPDATE FreeBoard_Account SET name='$input_name', password='$input_pw', email='$input_email' WHERE id='$login_id'";
            }
            if ($result = mysqli_query($conn, $query)) {
                echo "location.href='./profile.php';";
            }
        }
    }
}
?>
</script>
</html>