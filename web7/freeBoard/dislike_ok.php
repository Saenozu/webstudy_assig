<?php
include('./config.php');
include('./db.php');

$con_no = intval($_GET['no']);

$query = "SELECT * FROM FreeBoard_Likes WHERE uid='$login_id' and type='D' and con_no=$con_no";
if (mysqli_num_rows(mysqli_query($conn, $query))) { //싫어요 취소
    $delete_query = "DELETE FROM FreeBoard_Likes WHERE uid='$login_id' and type='D' and con_no=$con_no";
    if (!mysqli_query($conn, $delete_query)) {
        "<script>alert('delete fail');</script>";
    }
    $update_query = "UPDATE FreeBoard_Post SET down=down-1 WHERE no=$con_no";
    if (!mysqli_query($conn, $update_query)) {
        "<script>alert('update fail');</script>";
    }
} else { //싫어요
    $add_query = "INSERT INTO FreeBoard_Likes(con_no, uid, type) VALUES ($con_no, '$login_id', 'D')";
    if (!mysqli_query($conn, $add_query)) {
        "<script>alert('insert fail');</script>";
    }
    $update_query = "UPDATE FreeBoard_Post SET down=down+1 WHERE no=$con_no";
    if (!mysqli_query($conn, $update_query)) {
        "<script>alert('update fail');</script>";
    }
}
echo "<script>window.location.href = document.referrer;</script>";
?>