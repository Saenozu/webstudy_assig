<html lang='ko'>
<head>
<meta charset='UTF-8'>
<title> 배스킨라빈스 31 </title>
<style>
	@font-face {
		font-family: 'CookieRunOTF-Bold';
		src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_twelve@1.0/CookieRunOTF-Bold00.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}
	body {
		background: rgb(252,204,226) url('./IMAGE/Pattern.jpg') center/contain;
	}
	#CONTENT {
		width: 600px;
		height: 400px;
		margin: 0 auto;
		margin-top: 150px;
		background-color: #FFF;
		display: flex;
		justify-contents: center;
	}
	#MAIN {
		width: 80%;
		border: 10px solid rgb(238, 81, 150);
		background: #FFF url('./IMAGE/BACKGROUND.jpg') center/contain no-repeat;
	}
	#MAIN_ALBA_BOX {
		width: 150px;
		height: 80px;
		margin-top: 95px;
		margin-left: 250px;
	}
	#MAIN_ALBA_MSG {
		width: 80%;
		height: 100%;
		margin: 0 auto;
		line-height:80px;
		font-size: 26px;
		text-align: center;
		font-family: 'CookieRunOTF-Bold';
	}
	#MAIN_MY_BOX {
		width: 150px;
		height: 80px;
		font-size: 26px;
		text-align: center;
		font-family: 'CookieRunOTF-Bold';
		margin-top: 90px;
		margin-left: 33px;
	}
	#MAIN_MY_PRE_MSG {
		width: 80%;
		height: 40%;
		margin: 0 auto;
		line-height: 32px;
		font-size: 20px;
		text-align: center;
		font-family: 'CookieRunOTF-Bold';
	}
	#MAIN_MY_MSG {
		width: 80%;
		height: 60%;
		margin: 0 auto;
		font-size: 28px;
		text-align: center;
		font-family: 'CookieRunOTF-Bold';
		background-color: rgba(0,0,0,0);
		border: none;
		border: 1px solid #000;
	}
	#UI {
		width: 20%;
	}
	#UI_SAVE {
		width: 100%;
		height: 33.3%;
		background-color: white;
	}
	#UI_LOAD {
		width: 100%;
		height: 33.3%;
		background-color: white;
	}
	#UI_SUBMIT {
		width: 100%;
		height: 33.3%;
		background-color: white;
	}
	#BT_SAVE {
		width: 100%;
		height: 100%;
		color: rgb(63, 31, 32);
		font-size: 30px;
		font-family: 'CookieRunOTF-Bold';
		text-shadow: -1px 0 #FFF, 0 1px #FFF, 1px 0 #FFF, 0 -1px #FFF;
		border: 10px solid rgb(63, 31, 32);
		border-bottom: 5px solid rgb(63, 31, 32);
		background: url('./IMAGE/SAVE.png') center/contain no-repeat;
	}
	#BT_LOAD {
		width: 100%;
		height: 100%;
		color: rgb(63, 31, 32);
		font-size: 30px;
		font-family: 'CookieRunOTF-Bold';
		text-shadow: -1px 0 #FFF, 0 1px #FFF, 1px 0 #FFF, 0 -1px #FFF;
		border: 10px solid rgb(63, 31, 32);
		border-top: 5px solid rgb(63, 31, 32);
		border-bottom: 5px solid rgb(63, 31, 32);
		background: url('./IMAGE/LOAD.png') center/contain no-repeat;
	}
	#BT_SUBMIT {
		width: 100%;
		height: 100%;
		color: rgb(63, 31, 32);
		font-size: 30px;
		font-family: 'CookieRunOTF-Bold';
		text-shadow: -1px 0 #FFF, 0 1px #FFF, 1px 0 #FFF, 0 -1px #FFF;
		border: 10px solid rgb(63, 31, 32);
		border-top: 5px solid rgb(63, 31, 32);
		background: url('./IMAGE/SUBMIT.png') center/contain no-repeat;
	}
</style>
<script>
	function clear() {
		document.getElementById('MAIN_ALBA_MSG').innerHTML = "";
		document.getElementById('MAIN_MY_MSG').innerHTML = "";
	}
	function printNums(me,alba) {
		document.getElementById('MAIN_MY_PRE_MSG').innerHTML = me;
		document.getElementById('MAIN_ALBA_MSG').innerHTML = alba;
	}
</script>
</head>
<body>
<form method='POST' action=''>
	<div id=CONTENT>
		<div id=MAIN>
			<div id=MAIN_ALBA_BOX>
				<p id=MAIN_ALBA_MSG></p>
			</div>
			<div id=MAIN_MY_BOX>
				<p id=MAIN_MY_PRE_MSG></p>
				<input id=MAIN_MY_MSG type='text' name='text' placeholder='1 2 3'/>
			</div>
		</div>
		<div id=UI>
			<div id=UI_SAVE>
				<input id=BT_SAVE type='submit' name='save' value='저장'/>
			</div>
			<div id=UI_LOAD>
				<input id=BT_LOAD type='submit' name='load' value='로드'/>
			</div>
			<div id=UI_SUBMIT>
				<input id=BT_SUBMIT type='submit' name='submit' value='입력'/>
			</div>
		</div>
	</div>
</form>
</body>
<?php
session_start();
$key = rand(1,3);  #알바생이 말할 숫자 개수 = 키값
$myNums = $_POST['text'];  #내가 입력한 숫자들
$myLastNum = end(array_map('intval',explode(" ",$myNums)));
# Press save
if (isset($_POST["save"])) {
	$saveMyNums = $_SESSION['myPreNums'];
	$saveAlbaNums = $_SESSION['albaPreNums'];
	# Have save data
	if (isset($saveMyNums)) {
		setcookie("saveMe",$saveMyNums, time() + 10 * 60);
		setcookie("saveAlba",$saveAlbaNums, time() + 10 * 60);
		echo "<script>alert('저장했습니다!');";
		echo "printNums('".$_SESSION['myPreNums']."','".$_SESSION['albaPreNums']."'); </script>";
	}
	# No save data
	else {
		echo "<script> alert('저장할 데이터가 없습니다!'); clear(); </script>";
	}
	
}
# Press load
if (isset($_POST["load"])) {
	# Have load data
	if (isset($_COOKIE['saveAlba'])) {
		$_SESSION["myPreNums"] = $_COOKIE["saveMe"];
		$_SESSION["albaPreNums"] = $_COOKIE["saveAlba"];
		echo "<script>alert('불러왔습니다!');";
	}
	# No load data
	else {
		echo "<script>alert('불러올 데이터가 없습니다!');";
	}
	echo "printNums('".$_SESSION['myPreNums']."','";
	echo $_SESSION['albaPreNums']."'); </script>";
}
# Press submit
if (isset($_POST["submit"])) {
	if (empty($_POST['text'])) {
		echo "<script>alert('숫자를 입력해주세요.');";
		echo "printNums('".$_SESSION['myPreNums']."','".$_SESSION['albaPreNums']."'); </script>";
		return;
	}
	# am i win?
	if ($myLastNum >= 31) {
		unset($_SESSION['myPreNums']);
		unset($_SESSION['albaPreNums']);
		echo "<script>alert('패배하셨습니다.'); clear();</script>";
		return;
	}
	# is computer win?
	elseif ($myLastNum + $key >= 31) {
		unset($_SESSION['AlbaPreArr']);
		echo "<script>alert('승리하셨습니다.'); clear();</script>";
		return;
	} else {
		# Get Alba's numbers
		for ($i = 1; $i <= $key; $i++) {
			if ($i == 1) $_SESSION['albaPreNums'] = strval($myLastNum + $i);
			else $_SESSION['albaPreNums'] = $_SESSION['albaPreNums']." ".strval($myLastNum + $i);
		}
	}

	$_SESSION['myPreNums'] = $myNums;
	echo "<script>printNums('".$_SESSION['myPreNums']."','".$_SESSION['albaPreNums']."'); </script>";
}
?>
</html>