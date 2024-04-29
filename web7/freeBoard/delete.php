<?php
    include('./config.php');
    include('./db.php');
    
    $con_type = $_GET['type'];
    $con_no = intval($_GET['no']);
    $r_no = intval($_GET['r_no']);

    if (!isset($_SESSION['is_login'])) {
        echo "<meta http-equiv='refresh' content='0;url=./''>";
    }
    
    if ($con_type == 'post') {
        $query = "SELECT * FROM FreeBoard_Post WHERE no=$con_no";
        if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
            $row = mysqli_fetch_array($result);
            if ($login_name != $row['user'] && $login_id != 'admin0') { 
                echo "<script>location.href='./?type=post&no=$con_no'</script>;";
            }else {
                //게시글
                $delete_query = "DELETE FROM FreeBoard_Post WHERE no=$con_no";
                $delete_result = mysqli_query($conn,$delete_query);
                //댓글
                $delete_query = "DELETE FROM FreeBoard_Reply WHERE con_no=$con_no";
                $delete_result = mysqli_query($conn,$delete_query);
                echo "<meta http-equiv='refresh' content='0;url=./''>";
            }
        } else { echo "<script>console.log('Fail');</script>"; }
    }
    else if ($con_type == 'reply') {
        $query = "SELECT * FROM FreeBoard_Reply WHERE r_no=$r_no";
        if (mysqli_num_rows($result = mysqli_query($conn,$query))) {
            $row = mysqli_fetch_array($result);
            if ($login_name != $row['r_user'] && $login_id != 'admin0') { 
                echo "<script>location.href='./?type=post&no=$con_no'</script>;";
            } else {
                $delete_query = "DELETE FROM FreeBoard_Reply WHERE r_no>=$r_no and r_group=".$row['r_group']." and r_class>=".$row['r_class']."";
                $delete_result = mysqli_query($conn,$delete_query);
                echo "<script>location.href='./?type=post&no=$con_no'</script>;";
            }
        }
    }
    echo "<meta http-equiv='refresh' content='0;url=./''>";
?>