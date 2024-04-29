<?php
include('./config.php');
include('./db.php');

$con_no = intval($_GET['no']);

$query = "SELECT * FROM FreeBoard_Likes WHERE uid='$login_id' and type='U' and con_no=$con_no";
if (mysqli_num_rows(mysqli_query($conn, $query))) { //좋아요 취소
    $delete_query = "DELETE FROM FreeBoard_Likes WHERE uid='$login_id' and type='U' and con_no=$con_no";
    if (!mysqli_query($conn, $delete_query)) {
        "<script>alert('delete fail');</script>";
    }
    $update_query = "UPDATE FreeBoard_Post SET up=up-1 WHERE no=$con_no";
    if (!mysqli_query($conn, $update_query)) {
        "<script>alert('update fail');</script>";
    }
} else { //좋아요
    $add_query = "INSERT INTO FreeBoard_Likes(con_no, uid, type) VALUES ($con_no, '$login_id', 'U')";
    if (!mysqli_query($conn, $add_query)) {
        "<script>alert('insert fail');</script>";
    }
    $update_query = "UPDATE FreeBoard_Post SET up=up+1 WHERE no=$con_no";
    if (!mysqli_query($conn, $update_query)) {
        "<script>alert('update fail');</script>";
    }
}
echo "<script>window.location.href = document.referrer;</script>";
?>