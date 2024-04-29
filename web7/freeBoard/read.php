<?php

    if (!isset($_SESSION['is_login'])) {
        echo "<script>alert('접근할 수 없습니다.'); location.href='./'</script>";
    }
    $con_no = intval($_GET['no']);

    $query = "SELECT * FROM FreeBoard_Post WHERE no=$con_no";
    if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
        $row = mysqli_fetch_array($result);
        $c_user = $row['user'];
        $c_title = $row['title'];
        $c_content = $row['content'];
        $c_date = strtotime(strval($row['date']));
        $c_date = date("Y-m-d H:i", $c_date);
        $c_file = $row['file'];
        $c_pw = $row['pw'];
        $c_lock_flag = $row['lock_flag'];
        $c_hit = $row['hit'];
        $c_up = $row['up'];
        $c_down = $row['down'];
        $c_depth = $row['depth'];
        $c_origin = $row['re_no'];
    }
    $query = "SELECT * FROM FreeBoard_Post WHERE no=$c_origin";
    if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
        $row = mysqli_fetch_array($result);
        $c_origin_user = $row['user'];
    }

    #파일 이름에서 숫자 떼기
    $nonumfile = substr($c_file, 11)
?>
<style>
    #post_read_wrap {
        border: 1px solid #BFCDD9;
        padding: 29px;
    }
    #post_read_table {
        border: 0;
        border-bottom: 1px solid #BFCDD9;
        border-collapse: collapse;
    }
    #post_title {
        text-align: left;
        font-size: 24px;
    }
    .post_writer_info {
        width: 50%;
        font-size: 13px;
        text-align: left;
        padding: 20px 0;
        color: #666;
        border-bottom: 1px solid #BFCDD9;
    }
    .read_writer {
        color: #000;
    }
    .post_date_hit {
        font-size: 12px;
    }
    .read_date {
        padding-right: 8px;
    }
    .post_control_mode {
        border-bottom: 1px solid #BFCDD9;
        text-align: right;
        padding: 20px 0;
        vertical-align: bottom;
    }
    .post_control_mode a {
        font-size: 14px;
        color: #000;
    }
    .post_container {
        text-align: left;
        padding: 48px 28px;
    }
    .post_file_download {
        color: #666;
        text-align: left;
        padding: 8px 25px;
        border-bottom: 1px solid #BFCDD9;
    }
    .post_file_download a {
        color: #666;
    }
    .reply_title {
        border-top: 1px solid #BFCDD9;
        margin: 28px;
        padding: 28px 0;
        text-align: left;
        font-size: 16px;
    }
    .reply_input_row {
        padding: 2em;
        border-top:1px solid #BFCDD9;
        background-color: #DEF3F8;
    }
    .reply_input {
        padding: 12px;
        border: 1px solid #BFCDD9;
        border-radius: 6px;
        background-color: #FFF;
    }
    .reply_input textarea {
        width: 100%;
        min-height: 24px;
        font-size: 13px;
        color: #666;
        overflow-y: hidden;
        background-color: #FFF;
        margin: 8px 0 4px;
        resize: none;
    }
    .reply_input .btn_submit {
        height: 58px;
    }
    .reply_group {
        width: 100%;
        text-align: left;
        background-color: #DEF3F8;
    }
    .reply_class {
        width: 100%;
        border-top: 1px solid #BFCDD9;
        padding: 1em 0 0 1em;
        text-align: left;
        box-sizing: border-box;
    }
    .reply_class .reply_content_area {
        padding-bottom: 1em;
    }
    .reply_class a {
        color: #405F73;
    }
    .reply {
        border-bottom: 0;
    }
    .reply_content {
        padding: 4px 0 2px;
    }
    .reply_date,
    .reply_date a {
        color: #95A5BA;
        font-size: 11px;
    }
    .reply_input input[type=checkbox] {
        appearance: checkbox;
        display: none;
    }
    .like_wrap {
        display: inline-block;
        padding: 0 36px 36px;
    }
    #like, #dislike {
        width: 40px;
        height: 40px;
    }
    #like_numText,
    #dislike_numText {
        padding-top: 8px;
        text-align: center;
    }
    #like.checked {
        background: url('./Images/like_checked.png') center/contain;
    }
    #like.unchecked {
        background: url('./Images/like_unchecked.png') center/contain;
    }
    #dislike.checked {
        background: url('./Images/dislike_checked.png') center/contain;
    }
    #dislike.unchecked {
        background: url('./Images/dislike_unchecked.png') center/contain;
    }
    #like_numText.checked {
        color: #2DA823;
    }
    #like_numText.unchecked {
        color: #666;
    }
    #dislike_numText.checked {
        color: #B80004;
    }
    #dislike_numText.unchecked {
        color: #666;
    }
</style>
<?php
    if ($c_lock_flag) { //비밀글
        if ($c_user != $login_name && $_SESSION['user_id'] != 'admin0' && $c_origin_user != $login_name ) { //작성자 또는 관리자가 아니면 비밀번호 입력
            require('pw_check.php');
            if ($pw_try === $c_pw) {
                $_SESSION['access_chk_'.$con_no] = true;
            }
        }
    }
    if ($_SESSION['access_chk_'.$con_no]) {
        echo "<script>document.getElementById('post_check_wrap').style.display = 'none'; </script>";
    }
    if ($c_user == $login_name || $login_id == 'admin0' || $_SESSION['access_chk_'.$con_no] || $c_origin_user == $login_name || $c_lock_flag == 0) {
        
        if (!isset($_SESSION['post_hit_'.$con_no])) {
            $query = "UPDATE FreeBoard_Post SET hit=hit+1 WHERE no=$con_no";
            mysqli_query($conn, $query);

            $_SESSION['post_hit_'.$con_no] = TRUE;

            $c_hit++;
        }
?>
<!--post(S)-->
<div id='post_read_wrap'>
    <table id='post_read_table'>
        <!--title(S)-->
        <tr>
            <td colspan='2'>
                <h3 id='post_title'><?php if($c_depth > 0) {echo "<span style='color: #555BD9;'>RE: </span>";} echo $c_title; ?></h3>
            </td>
        </tr>
        <!--title(E)-->
        <!--post info(S)-->
        <tr>
            <!--user, date, hit(S)-->
            <td class='post_writer_info'>
                <div><span class='read_writer'>작성자 <?php echo $c_user; ?></span></div>
                <div class='post_date_hit'>
                    <span class='read_date'><?php echo $c_date; ?></span>
                    <span class='read_hit'>조회 <?php echo $c_hit; ?></span>
                </div>
            </td>
            <!--user, date, hit(E)-->
            <!--modify, delete(S)-->
            <td class='post_control_mode'>
                <a href='write.php?no=<?php echo $con_no; ?>'>답글</a>
            <?php 
                if ($c_user == $_SESSION['user_name'] || $_SESSION['user_id'] == 'admin0') {
            ?>
                &nbsp;|&nbsp;
                <a href='modify.php?no=<?php echo $con_no; ?>'>수정</a>
                &nbsp;|&nbsp;
                <a href='delete.php?type=post&no=<?php echo $con_no; ?>'>삭제</a>
                <?php } ?>
            </td>
            <!--modify, delete(E)-->
        </tr>
        <!--post info(E)-->
        <!--content(S)-->
        <tr>
            <td class='post_container' colspan='2'>
                <?php
                    $c_content = nl2br(htmlspecialchars($c_content));
                    echo $c_content
                ?>
            </td>
        </tr>
        <!--content(E)-->
        <!--like & unlike(S)-->
        <tr>
            <!--like(S)-->
            <td style='text-align: right;'>
                <div class='like_wrap'>
                    <button type='button' id='like' class='unchecked' onclick="window.location.href='./like_ok.php?no=<?php echo $con_no; ?>'"></button>
                    <p id='like_numText' class='unchecked'><?php echo $c_up; ?></p>
                </div>
            </td>
            <!--like(E)-->
            <!--dislike(S)-->
            <td style='text-align: left;'>
                <div class='like_wrap'>
                    <button type='button' id='dislike' class='unchecked' onclick="window.location.href='./dislike_ok.php?no=<?php echo $con_no; ?>'"></button>
                    <p id='dislike_numText' class='unchecked'><?php echo $c_down; ?></p>
                </div>
            </td>
            <!--dislike(E)-->
        </tr>
        <!--like & unlike(E)-->
        <!--file download(S)-->
        <tr>
            <td class='post_file_download' colspan='2'>
                첨부파일: 
                <a href='download.php?type=post&no=<?php echo $con_no; ?>' onclick='' >
                    <?php echo $nonumfile; ?>
                </a>
            </td>
        </tr>
        <!--file download(E)-->
        <!--number of reply(S)-->
        <?php
            $query = "SELECT * FROM FreeBoard_Reply WHERE con_no=$con_no ORDER BY r_group";
            $result = mysqli_query($conn,$query);
            $total_reply = mysqli_num_rows($result);
        ?>
        <tr><td colspan='2' class='reply_title'>댓글(<?php echo $total_reply; ?>)</td></tr>
        <!--number of reply(E)-->
        <!--reply(S)-->
        <?php
            if ($total_reply) {
                $cnt = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $r_no = $row['r_no']; //댓글 기본키
                    $r_group = $row['r_group']; //댓글 그룹
                    $r_class = $row['r_class']; //대댓 깊이
                    $r_user = $row['r_user']; //댓글 작성자
                    $r_content = $row['r_content']; //댓글 내용
                    $r_date = strtotime(strval($row['r_date']));
                    $r_date = date("Y-m-d H:i", $r_date);
                    $r_lock_flag = $row['r_lock_flag']; //비밀 댓글
                    $r_pw = $row['r_pw']; //댓글 비밀번호

                    $class_query = "SELECT * FROM FreeBoard_Reply WHERE r_group=$r_group and con_no=$con_no";
                    $class_cnt = mysqli_num_rows(mysqli_query($conn, $class_query));

                    $next_class = $r_class+1;

                    if ($r_class == 0) {
                        echo "
                        <tr>
                            <td class='reply_group' colspan='2'>
                        ";
                    }

                    //수정 영역
                    echo "<div class='reply_input_area disable'>
                        <div class='reply_input_row' style='border-bottom: 0;'>
                            <div class='reply_input'>
                                <form method='post' action=''>
                                    <p style='text-align: left;'>$login_name</p>
                                    <textarea name='content' wrap='hard' cols='70' rows='1' oninput='auto_grow(this)' placeholder='내용을 입력해주세요' maxlength='1500'>$r_content</textarea>
                                    <div style='display: flex; justify-content: center;'>
                                        <div style='margin: 0;'>
                                            <input type='hidden' name='group' value='$r_group'/>
                                            <input type='hidden' name='class' value='$r_class'/>
                                            <input type='checkbox' id='check_lock_{$cnt}_0' onclick='click_lock(event, $cnt, 0)' name='locked' value='1'/>
                                            <label for='check_lock_{$cnt}_0' id='lock_text_{$cnt}_0' style='color: #95A5BA'>비밀글</label>
                                        </div>
                                        <div style='margin-right: 0;'>
                                            <button type='button' onclick='reply_cancel()' value='1'>취소</button>
                                            <button type='submit' name='submit_reply_modify' value='1'>수정</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";

                    if ($r_lock_flag && ($r_user != $login_name && $login_id != 'admin0' && $c_user != $login_name)) {
                        echo "
                            <div class='reply_class'>
                                <div class='reply_content_area'>
                                    $r_user ";
                        if ($r_user == $login_name || $login_id == 'admin0') {
                            echo "<a onclick='reply_modify($cnt)'>| 수정</a> <a href='delete.php?type=reply&no=$con_no&r_no=$r_no'>| 삭제</a>";
                        }
                        echo "
                                    <p class='reply_content'>[ 비밀글입니다 ]</p>
                                    <p class='reply_date'>$r_date <a onclick='reply_reply($cnt)'>답글 쓰기</a></p>
                                </div>
                        ";
                    } else {
                        echo "
                            <div class='reply_class'>
                                <div class='reply_content_area'>
                                    $r_user ";
                        if ($r_user == $login_name || $login_id == 'admin0') {
                            echo "<a onclick='reply_modify($cnt)'>| 수정</a> <a href='delete.php?type=reply&no=$con_no&r_no=$r_no'>| 삭제</a>";
                        }
                        echo "
                                    <p class='reply_content'>".nl2br(htmlspecialchars($r_content))."</p>
                                    <p class='reply_date'>$r_date <a onclick='reply_reply($cnt)'>답글 쓰기</a></p>
                                </div>
                        ";
                    }
                    //답글 입력 영역
                    echo "<div class='reply_input_area disable'>
                        <div class='reply_input_row' style='border-bottom: 0;'>
                            <div class='reply_input'>
                                <form method='post' action=''>
                                    <p style='text-align: left;'>$login_name</p>
                                    <textarea name='content' wrap='hard' cols='70' rows='1' oninput='auto_grow(this)' placeholder='내용을 입력해주세요' maxlength='1500'></textarea>
                                    <div style='display: flex; justify-content: center;'>
                                        <div style='margin: 0;'>
                                            <input type='hidden' name='group' value='$r_group'/>
                                            <input type='hidden' name='class' value='$next_class'/>
                                            <input type='checkbox' id='check_lock_{$cnt}_1' onclick='click_lock(event, $cnt, 1)' name='locked' value='1'/>
                                            <label for='check_lock_{$cnt}_1' id='lock_text_{$cnt}_1' style='color: #95A5BA'>비밀글</label>
                                        </div>
                                        <div style='margin-right: 0;'>
                                            <button type='button' onclick='reply_cancel()' value='1'>취소</button>
                                            <button type='submit' name='submit_reply_reply' value='1'>등록</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";
                    
                    

                    if ($class_cnt -1 == $r_class) {
                        for ($i = 0; $i < $class_cnt; $i++) {
                            echo "</div>";
                        }
                        echo "</td></tr>";
                    }
                    $cnt++;
                }
            }
        ?>
        <!--reply(E)-->
        <!--reply input(S)-->
        <tr class='reply_input_area'>
            <td colspan='2' class='reply_input_row'>
                <div class='reply_input'>
                    <form method='post' action=''>
                        <p style='text-align: left;'><?php echo $login_name; ?></p>
                        <textarea name='content' wrap='hard' cols='70' rows='1' oninput="auto_grow(this)" placeholder='내용을 입력해주세요' maxlength='1500'></textarea>
                        <div style='display: flex; justify-content: center;'>
                        <div style='margin: 0;'>
                            <input type='checkbox' id='check_lock____' onclick="click_lock(event, '_', '_')" name='locked' value='1'/>
                            <label for='check_lock____' id='lock_text____' style='color: #95A5BA'>비밀글</label>
                        </div>
                        <div style='margin-right: 0;'><button type='submit' name='submit_reply' value='1'>등록</button></div>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
        <!--reply input(E)-->
    </table>
</div>
<!--post(E)-->
<?php
        if (empty($c_file)) { //첨부파일 없으면 숨기기
            echo "<script>document.getElementsByClassName('post_file_download')[0].classList.add('disable');
            </script>";
        }
        
        $input_reply_content = $_POST['content'];
        $input_reply_content = mysqli_real_escape_string($conn, $input_reply_content);
        if ($_POST['submit_reply']) {
            $query = "SELECT DISTINCT r_group FROM FreeBoard_Reply WHERE con_no=$con_no";
            $group = mysqli_num_rows(mysqli_query($conn, $query));
            if (isset($_POST['locked'])) {
                $query = "INSERT INTO FreeBoard_Reply(con_no, r_group, r_class, r_user, r_content, r_lock_flag) VALUES ($con_no, $group, 0, '$login_name', '$input_reply_content', 1)";
                mysqli_query($conn, $query);
            } else {
                $query = "INSERT INTO FreeBoard_Reply(con_no, r_group, r_class, r_user, r_content) VALUES ($con_no, $group, 0, '$login_name', '$input_reply_content')";
                mysqli_query($conn, $query);
            }
            echo "<script>window.location.href = location.href;</script>";
        } //POST INPUT REPLY
        else if ($_POST['submit_reply_reply']) {
            if (isset($_POST['locked'])) {
                $query = "INSERT INTO FreeBoard_Reply(con_no, r_group, r_class, r_user, r_content, r_lock_flag) VALUES ($con_no, ".$_POST['group'].", ".$_POST['class'].", '$login_name', '$input_reply_content', 1)";
                mysqli_query($conn, $query);
            } else {
                $query = "INSERT INTO FreeBoard_Reply(con_no, r_group, r_class, r_user, r_content) VALUES ($con_no, ".$_POST['group'].", ".$_POST['class'].", '$login_name', '$input_reply_content')";
                mysqli_query($conn, $query);
            }
            echo "<script>window.location.href = location.href;</script>";
        } //POST INPUT REPLY REPLY
        else if ($_POST['submit_reply_modify']) {
            if (isset($_POST['locked'])) {
                $query = "UPDATE FreeBoard_Reply SET r_content='$input_reply_content', r_lock_flag=1 WHERE r_no=$r_no";
                mysqli_query($conn, $query);
            } else {
                $query = "UPDATE FreeBoard_Reply SET r_content='$input_reply_content', r_lock_flag=0 WHERE r_no=$r_no";
                mysqli_query($conn, $query);
            }
            echo "<script>window.location.href = location.href;</script>";
        } //POST MODIFY REPLY
    } //PW ACCEPT
?>
<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript"> 
    var reply_class = document.getElementsByClassName('reply_class');
    var reply_class_cnt = reply_class.length;
    var input_area = document.getElementsByClassName('reply_input_area');
    var input_area_cnt = input_area.length;
    var content_area = document.getElementsByClassName('reply_content_area');
    var content_area_cnt = content_area.length;
    
    var btn_like = document.getElementById('like');
    var txt_like = document.getElementById('like_numText');
    var btn_dislike = document.getElementById('dislike');
    var txt_dislike = document.getElementById('dislike_numText');

    function click_lock(event, cnt, flag) {
        console.log('lock_text_'+cnt+'_'+flag);
        if (event.target.checked) {
            document.getElementById('lock_text_'+cnt+'_'+flag).style.color = '#2DA823';
            document.getElementById('lock_text_'+cnt+'_'+flag).style.fontWeight = '700';
        } else {
            document.getElementById('lock_text_'+cnt+'_'+flag).style.color = '#95A5BA';
            document.getElementById('lock_text_'+cnt+'_'+flag).style.fontWeight = '500';
        }
    }
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }
    function reply_modify(cnt) {
        for (i = 0; i < reply_class_cnt; i++) {
            reply_class[i].style = '';
            reply_class[i].classList.remove('disable');
        }
        for (i = 0; i < input_area_cnt; i++)
            input_area[i].classList.add('disable');
        for (i = 0; i < content_area_cnt; i++)
            content_area[i].classList.remove('disable');
        
        reply_class[cnt].style.borderTop = 0;
        content_area[cnt].classList.add('disable');
        input_area[cnt*2].classList.remove('disable');
    }
    function reply_cancel() {
        for (i = 0; i < reply_class_cnt; i++) {
            reply_class[i].style = '';
            reply_class[i].classList.remove('disable');
        }
        for (i = 0; i < input_area_cnt; i++)
            input_area[i].classList.add('disable');
        for (i = 0; i < content_area_cnt; i++)
            content_area[i].classList.remove('disable');
        input_area[input_area_cnt-1].classList.remove('disable');
    }
    function reply_reply(cnt) {
        for (i = 0; i < reply_class_cnt; i++) {
            reply_class[i].style = '';
            reply_class[i].classList.remove('disable');
        }
        for (i = 0; i < input_area_cnt; i++)
            input_area[i].classList.add('disable');
        for (i = 0; i < content_area_cnt; i++)
            content_area[i].classList.remove('disable');
        input_area[cnt*2+1].classList.remove('disable');
    }
<?php
    $thumbs_up_query = "SELECT * FROM FreeBoard_Likes WHERE uid='$login_id' and type='U' and con_no=$con_no";
    if (mysqli_num_rows(mysqli_query($conn, $thumbs_up_query))) {
        echo "txt_like.classList.add('checked');
        txt_like.classList.remove('unchecked');
        btn_like.classList.add('checked');
        btn_like.classList.remove('unchecked');";
    }
    $thumbs_down_query = "SELECT * FROM FreeBoard_Likes WHERE uid='$login_id' and type='D' and con_no=$con_no";
    if (mysqli_num_rows(mysqli_query($conn, $thumbs_down_query))) {
        echo "txt_dislike.classList.add('checked');
        txt_dislike.classList.remove('unchecked');
        btn_dislike.classList.add('checked');
        btn_dislike.classList.remove('unchecked');";
    }
?>
</script>