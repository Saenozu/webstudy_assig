<?php
    if ($_POST['pw_check']) {
        $pw_try = $_POST['pw'];
    }
?>
<style>
    #post_check_wrap {
        border: 1px solid #BFCDD9;
        padding: 96px 29px;
    }
    #post_pw {
        border: 1px solid #666;
    }
</style>
<div id='post_check_wrap'>
    <form method='post' action='' style='padding: 4px 0 2px; text-align: center;'>
        <span>비밀번호:&nbsp;</span>
        <input type='password' id='post_pw' name='pw' style='padding: 3px;'/>
        <button type='submit' class='btn_submit' name='pw_check' value='1'>
            <span class='btn_text'>입력</span>
        </button>
    </form>
</div>
