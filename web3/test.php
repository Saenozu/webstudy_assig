<html>
<head>
<meta charset='UTF-8'>
<title>세션예제</title>
</head>
<body>
	<form method='POST' action=''>
		<input type='text' name='text'/>
		<input type='submit' name='submit' value='submit'/>
	</form>
</body>
<?php
	session_start();
	$myText = $_POST['text'];
	$_SESSION['test'] = $_SESSION['test'].$myText;

	echo $_SESSION['test'];
?>
</html>
