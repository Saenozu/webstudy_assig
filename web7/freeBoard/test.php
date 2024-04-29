<?php
include('./config.php');
include('./db.php');
include('./filter.php');

$check_time_query = "SELECT TIME FROM test WHERE IP='0.0.0.1'";
$lastTryTime = strval(mysqli_fetch_array(mysqli_query($conn,$check_time_query))['TIME']);
echo $lastTryTime;

?>
