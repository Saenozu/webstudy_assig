<html lang='ko'>
<?php
	session_start(); //세션 사용을 위해 세션 시작
	$myText = $_POST['inputText'];
	//내가 입력한 숫자배열 생성
	$myNums = array();
	for ($i = 0; $i < 3; $i++) {
		$tmp = intval(substr($myText, $i, 1));
		array_push($myNums, $tmp);
	}
	//저장하기
	if (isset($_POST['save'])) {
		$gameTry = $_SESSION['Try'];
		$randNum = $_SESSION['Answer'];
		$cntSBO = $_SESSION['SBO'];
		//게임이 시작되지 않음
		if (empty($_SESSION['Answer'])) {
			echo "<script>alert('저장할 수 있는 데이터가 없습니다!');</script>";
		}
		//게임이 진행중임
		else {
			setcookie('saveAnswer',$randNum,time()+10*60);
			setcookie('saveTry',$gameTry,time()+10*60);
			setcookie('saveSBO', $cntSBO,time()+10*60);
		}
	}
	//불러오기
	elseif (isset($_POST['load'])) {
		//쿠키가 존재하지 않을 때
		if (empty($_COOKIE['saveAnswer'])) {
			echo "<script>alert('불러올 수 있는 데이터가 없습니다!');</script>";
		}
		//쿠키가 존재할 때
		else {
			//쿠키를 세션에 저장
			$_SESSION['Answer'] = $_COOKIE['saveAnswer'];
			$_SESSION['Try'] = $_COOKIE['saveTry'];
			$_SESSION['SBO'] = $_COOKIE['saveSBO'];
		}
	}
?>
<head>
	<meta charset='UTF-8'>
	<title> 숫자야구게임 </title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap');
		body {
			background: #000000 url('./Image/background.jpg') no-repeat center top;
			background-size: cover;
		}
		#backBoard {
			width: 750px;
			margin: 0 auto;
			margin-top: 50px;
			padding: 20px;
			padding-bottom: 50px;
			background-color: rgb(28, 28, 28);
			border-radius: 20px;
		}
		h1 {
			font-family: 'Do Hyeon', sans-serif;
			color: #d9d9d9;
			font-size: 45px;
			margin: 0 auto;
			padding-bottom: 30px;
		}
		#scoreBoard {
			width: 600px;
			border: 5px double #d9d9d9;
			padding: 50px;
			margin: 0 auto;
			display: flex;
			justify-content: center;
			background-color: rgb(49, 49, 49);
		}
		.Count {
			width: 50%;
			
		}
		table {
			margin: 0 auto;
			text-align: center;
			table-layout: fixed;
			border-spacing: 0px;
			font-family: 'Do Hyeon', sans-serif;
		}
		.SBO {
			font-size: 50px;
			width: 60px;
			color: #d9d9d9;
			text-align: left;
		}
		.strike, .ball, .out {
			width: 55px;
			background: url('./Image/Blight.png') no-repeat center center;
			background-size: 55px 55px;
		}
		#playUI {
			width: 750px;
			height: 250px;
			margin: 30px auto 30px auto;
			padding: 20px;
			background-color: rgba(30,30,30,0.4);
			border-radius: 20px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#slArea, #textArea, #submitArea {
			width: 33%;
			
		}
		#save, #load, #submit {
			width: 100px;
			height: 100px;
			margin: 0 auto;
			outline: none;
			display: block;
			border: none;
			border-shadow: none;
			
		}
		#save {
			background: url('./Image/save.png');
			background-size: 100px 100px;
		}
		#load {
			background: url('./Image/load.png');
			background-size: 100px 100px;
		}
		#submit {
			background: url('./Image/baseball.png');
			background-size: 100px 100px;
		}
		#inputText {
			width: 200px;
			height: 200px;
			font-size: 35px;
			text-align: center;
			border: none;
			border-shadow: none;
			background: url('./Image/strikeZone.png');
			background-size: 200px;
		}
		#try {
			color: lime;
			font-size: 50px;
			text-align: right;
		}
	</style>
	<script>
		function lightStrike(flag) { //strike 불 켜기, 끄기
			var strikes = document.getElementsByClassName("strike");
			if (flag == 0) { //불 끄기
				for (var i = 0; i < strikes.length; i++) {
					strikes[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					strikes[i].style.backgroundSize = "55px";
				}
			}
			else { //불 켜기
				for (var i = 0; i < flag; i++) {
					strikes[i].style.background="rgb(49, 49, 49) url('./Image/Ylight.png') no-repeat center center";
					strikes[i].style.backgroundSize = "55px";
				}
				for (var i = flag; i < strikes.length; i++) {
					strikes[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					strikes[i].style.backgroundSize = "55px";
				}
			}
		}
		function lightBall(flag) { //ball 불 켜기, 끄기
			var balls = document.getElementsByClassName("ball");
			if (flag == 0) { //불 끄기
				for (var i = 0; i < balls.length; i++) {
					balls[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					balls[i].style.backgroundSize = "55px";
				}
			}
			else { //켜기
				for (var i = 0; i < flag; i++) {
					balls[i].style.background="rgb(49, 49, 49) url('./Image/Glight.png') no-repeat center center";
					balls[i].style.backgroundSize = "55px";
				}
				for (var i = flag; i < balls.length; i++) {
					balls[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					balls[i].style.backgroundSize = "55px";
				}
			}
		}
		function lightOut(flag) { //out 불 켜기, 끄기
			var outs = document.getElementsByClassName("out");
			if (flag == 0) { //끄기
				for (var i = 0; i < outs.length; i++) {
					outs[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					outs[i].style.backgroundSize = "55px";
				}
			}
			else { //켜기
				for (var i = 0; i < flag; i++) {
					outs[i].style.background="rgb(49, 49, 49) url('./Image/Rlight.png') no-repeat center center";
					outs[i].style.backgroundSize = "55px";
				}
				for (var i = flag; i < outs.length; i++) {
					outs[i].style.background="rgb(49, 49, 49) url('./Image/Blight.png') no-repeat center center";
					outs[i].style.backgroundSize = "55px";
				}
			}
		}
		function cntRound(round) { //시도횟수 출력
			document.getElementById("try").innerHTML = round + " 회";
		}
	</script>
</head>
<body align="center">
	<!--내용 묶음-->
	<div id="content">
	<!--진한 회색 둥근 사각형 구역-->
	<div id="backBoard">
		<h1> Bulls and Cows </h1>
		<!--연한 회색 사각형 구역-->
		<div id="scoreBoard">
			<!--점수판 출력 구역-->
			<div class="Count">
				<table>
					<tr> <!--스트라이크 카운트 출력-->
						<td class="SBO">S</td>
						<td class="strike"></td>
						<td class="strike"></td>
					</tr>
					<tr> <!--볼 카운트 출력-->
						<td class="SBO">B</td>
						<td class="ball"></td>
						<td class="ball"></td>
						<td class="ball"></td>
					</tr>
					<tr> <!--아웃 카운트 출력-->
						<td class="SBO">O</td>
						<td class="out"></td>
						<td class="out"></td>
						<td class="out"></td>
					</tr>
				</table>
			</div>
			<!--시도횟수 출력 구역-->
			<div class="Count">
				<h1 id="try">회</h1>
			</div>
		</div> <!--#scoreBoard-->
	</div> <!--#backBoard-->
	
	<!--아래구역-->
	<form method="POST" action="">
		<!--반투명 회색 둥근 사각형 구역-->
		<div id="playUI">
			<!--Save와 Load 버튼 구역-->
			<div id="slArea">
				<input id="save" type="submit" value="save" name="save"/>
				<input id="load" type="submit" value="load" name="load"/>
			</div>
			<!--답 입력 구역-->
			<div id="textArea">
				<input id="inputText" type="text" name="inputText"/>
			</div>
			<!--제출 버튼 구역-->
			<div id="submitArea">
				<input id="submit" type="submit" value="submit" name="submit"/>
			</div>
		</div> <!--#playUI-->
	</form>
	</div> <!--#content-->
</body>
<?php
	if ($_POST['submit']) {
		//첫시도:난수 생성
		if (empty($_SESSION['Answer'])) {
			//randNum 변수에 0~9의 난수 3개를 배열로 초기화
			$randNum = array(rand(0,9),rand(0,9),rand(0,9));
			//세션 Answer에 숫자 사이에 공백을 추가하여 문자열로 초기화
			$_SESSION['Answer'] = implode(" ", $randNum);
			//시도횟수를 뜻하는 세션 Try를 0으로 초기화
			$_SESSION['Try'] = 0;
		}
		//첫시도가 아닐때
		else {
			//문자열인 세션 Answer을 공백으로 구분하여 randNum변수에 배열로 초기화
			$randNum = explode(" ", $_SESSION['Answer']);
		}
		
		//커닝을 위한 답지
		//echo "<script>console.log('Answer: ".$_SESSION['Answer']."');</script>";
		//카운트 초기화
		$S_cnt = 0; $B_cnt = 0; $O_cnt = 0;
		//시도횟수 증가
		$_SESSION['Try']++;
		//시도횟수 10회 이하일 때 카운트
		if ($_SESSION['Try'] <= 10) {
			for ($i = 0; $i < 3; $i++) {
				//같은 자리에 같은 숫자일 때 스트라이크 카운트 증가
				if ($randNum[$i] == $myNums[$i]) {
					$S_cnt++;
				}
				//답에 같은 숫자가 존재할 때 볼 카운트 증가
				else {
					for ($j = 0; $j < 3; $j++) {
						if ($randNum[$i] == $myNums[$j]) {
							$B_cnt++;
							break;
						}
					}
				}
			}
		}
		//아웃 카운트
		$O_cnt = 3 - ($S_cnt + $B_cnt);
		$_SESSION['SBO'] = $S_cnt*100+$B_cnt*10+$O_cnt;
		//3Strike 성공
		if ($S_cnt == 3) {
			echo "<script>alert('3Strike!! \\nTry: ".$_SESSION['Try']."\\nAnswer: ".$_SESSION['Answer']."');";
			//점수판 초기화
			echo "lightStrike(0); lightBall(0); lightOut(0); cntRound(0);</script>";
			//세션 해제
			unset($_SESSION['Try']);
			unset($_SESSION['Answer']);
			unset($_SESSION['SBO']);
		}
		//시도횟수 10회 초과
		elseif ($_SESSION['Try'] > 10) {
			echo "<script>alert('Failed!! \\nAnswer: '+'".$_SESSION['Answer']."');";
			//점수판 초기화
			echo "lightStrike(0); lightBall(0); lightOut(0); cntRound(0);</script>";
			//세션 해제
			unset($_SESSION['Try']);
			unset($_SESSION['Answer']);
			unset($_SESSION['SBO']);
		}
		//시도횟수 10회 이하이며 3Strike가 아님
		else {
			echo "<script>lightStrike($S_cnt); lightBall($B_cnt); lightOut($O_cnt); cntRound(".$_SESSION['Try']."); </script>";
		}
		return;
	}
	//save나 load를 눌렀을 때 점수판 출력
	if (empty($_SESSION['Answer'])) {
		echo "<script>lightStrike(0); lightBall(0); lightOut(0); cntRound(0); </script>";
	}
	else {
		$cntSBO = $_SESSION['SBO'];
		echo "<script>lightStrike(",floor($cntSBO/100),"); lightBall(",$cntSBO/10%10,"); lightOut(",$cntSBO%10,"); cntRound(",$_SESSION['Try'],"); </script>";
	}
?>
</html>