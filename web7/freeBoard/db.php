<?php
	$db_Host = "localhost";
	$db_Id = "snz2262";
	$db_Pass = "2022Wnsldj!";
	$db_Name = "snz2262";
	
	$conn = mysqli_connect($db_Host, $db_Id, $db_Pass, $db_Name);

	mysqli_query($conn, "set session character_set_connection=utf8;");
	mysqli_query($conn, "set session character_set_results=utf8;");
	mysqli_query($conn, "set session character_set_client=utf8;");
	
	//연결 오류시 종료
	if (mysqli_connect_errno())
		die('Connect Error : '.mysqli_connect_errno());
	
?>