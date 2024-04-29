<html lang='ko'>
<head>
<meta charset='UTF-8'>
<title>실습1</title>
<?php
	$myid = $_POST['myid'];
	$mypw = $_POST['mypw'];
	$myip = $_SERVER['REMOTE_ADDR'];

	$id = "snz2262";
	$pw = "sksajtwu";

	if ($myid == $id && $mypw == $pw) {
		setcookie('userLogin',$myid,time()+60*10);
		echo "Hello CAT-CERT <br>";
	}
	elseif ($myid == "admin")
		echo "<script>alert('Your IP: ".$myip." you are not admin')</script>";
	else
		echo "wrong password! <br>";
?>
</head>
<body>
<form method="POST" action="">
	<table border="1">
		<tr><td>CAT-LOGIN</td></tr>
		<tr><td><input type="text" name="myid"/></td></tr>
		<tr><td><input type="password" name="mypw"/></td></tr>
		<tr><td><input type="submit" name="submit" value="입력"/></td></tr>
	</table>
</form>
</body>
</html>
