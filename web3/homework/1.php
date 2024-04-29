<html>
<head>
	<title> homework1 </title>
</head>
<body>
	<form method="post" action="">
		입력: <input type="text" name="guguNum"/>
		<input type="submit" value="전송"/>
	</form>
</body>
<?php
        $num = $_POST['guguNum'];
        for ($i = 1; $i < 10; $i++)
                echo $num."X".$i." = ".$num*$i."<br>";
?>
</html>
