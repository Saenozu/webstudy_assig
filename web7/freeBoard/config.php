<?php
    session_start();

    if (isset($_SESSION['is_login'])) {
        if (isset($_SESSION['user_name']) || isset($_SESSION['user_id'])) {
            $login_name = $_SESSION['user_name'];
            $login_id = $_SESSION['user_id'];
            $login_no = $_SESSION['user_no'];
        }
    }
    else {
        $login_name = NULL;
        $login_id = NULL;
        $login_no = NULL;
    }
?>