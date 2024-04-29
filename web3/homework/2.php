<html lang='ko'>
<head>
	<meta charset='UTF-8'>
	<title>실습#2</title>
</head>
<body>
	홀수 짝수
	<form method='POST' action=''>
		시작:<input type='text' name='text'/>
		홀수<input type='radio' name='flag' value='0'/>
		짝수<input type='radio' name='flag' value='1'/>
		<input type='submit' name='submit' value='입력'/>
	</form>
</body>
<?php
	$myText = $_POST['text'];
	$FLAG = $_POST['flag'];
	
	$myFlag = $myText % 2;

	if ($FLAG == $myFlag) {
		if ($FLAG) {
			echo "입력한 수가 짝수가 아닙니다!";
		}
		else {
			echo "입력한 수가 홀수가 아닙니다!";
		}
		return;
	}

	$sum = 0;
	for ($i = $FLAG+1; $i <= $myText; $i+=2) {
		$sum += $i;
		echo $i;
		if ($i < $myText) {
			echo " + ";
		}
	}
	echo "=$sum";
?>
</html>
