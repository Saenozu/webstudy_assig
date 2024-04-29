<html lang='ko'>
<head>
<?php
	$myName = $_POST['iName']; #이름
	$myId = $_POST['iID']; #아이디
	$myPass = $_POST['iPass']; #비밀번호
	$checkPass = $_POST['iPass_ck']; #비밀번호확인
	$myNick = $_POST['iNick']; #닉네임
	$flagGender = $_POST['genAgree']; #성별정보수집동의
	$myGender = $_POST['iGender']; #성별
	$flagTel = $_POST['telAgree']; #휴대전화정보수집동의
	$myTel = $_POST['iTel']; #휴대전화
	$myYear = $_POST['iYear']; #생년월일
	$myMonth = $_POST['iMonth'];
	$myDay = $_POST['iDay'];
	$myEmail_head = $_POST['iEmail_h']; #이메일
	$myEmail_tail = $_POST['iEmail_t'];
	$myIntro = $_POST['iIntro']; #소개
	$myProfile = $_FILES['iProfile']; #프로필사진
	$authQuest = $_POST['iQuest']; #본인확인질문
	$authReply = $_POST['iReply']; #본인확인답변
	
?>
	<meta charset='UTF-8'>
	<title> 회원가입 정보 출력 </title>
	<style>
		body {
			background-color: #d9d9d9;
		}
		#Wrap {
			width: 600px;
			height: 600px;
			margin: 0 auto;
			position: relative;
		}
		#Contents {
			width: 500px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			position: absolute;
			left: 50%; top: 50%;
			transform: translate(-50%, -50%);
		}
		#Header {
			width: 500px;
			padding-bottom: 6px;
			font-weight: bold;
			font-size: 18px;
			border-bottom: 2px solid #666;
		}
		#PostContents {
			margin: 20px;
			font-size: 12px;
			font-weight: bold;
		}
		#Footer {
			width: 500px;
			padding-top: 6px;
			border-top: 2px solid #666;
		}
		#File {
			width: 100px;
			height: 100px;
			background-size: contain;
			background-repeat: no-repeat;
		}
		button {
			width: 100px;
			height: 40px;
			background-color: #3c3c3c;
			color: #fff;
			font-size: 14px;
			border: 1px solid #d9d9d9;
		}
		p {
			font-weight: normal;
			display: inline;
		}
	</style>
</head>
<body>
<div id='Wrap'>
	<div id='Contents'>
		<div id='Header'> ▶ 회원정보확인 </div>
		<div id='PostContents'>
			이름: <p id='Name'></p><br>
			아이디: <p id='ID'></p><br>
			비밀번호: <p id='Password'></p><br>
			성별: <p id='Gender'></p><br>
			별명: <p id='Nick'></p><br>
			생년월일: <p id='Birth'></p><br>
			이메일: <p id='Email'></p><br>
			휴대전화: <p id='Tel'></p><br>
			소개: <p id='Intro'></p><br>
			프로필: <div id='File'></div><br>
			본인확인질문: <p id='Ask'></p><br>
			본인확인답변: <p id='Answer'></p><br>
		</div>
		<div id='Footer' align='center'>
			<button type='button' onclick="location.href='./index.html'" name='goBack'> 돌아가기 </button>
		</div>
	</div>
</div>
</body>
<?php
	$link = 'http://junior.catsecurity.net/~snz2262/web3/registerPage/index.html';
	#이름
	if ($myName) 
		echo "<script>document.getElementById('Name').innerHTML = '".$myName."';</script>";
	else
		echo "<script>alert('이름을 입력해주세요'); location.href='".$link."';</script>";
	#아이디
	if ($myId)
		echo "<script>document.getElementById('ID').innerHTML = '".$myId."';</script>";
	else
		echo "<script>alert('아이디를 입력해주세요'); location.href='".$link."';</script>";
	#비밀번호
	if ($myPass != $checkPass)
		echo "<script>alert('비밀번호 불일치!'); location.href='".$link."';</script>";
	else
		echo "<script>document.getElementById('Password').innerHTML = '".$myPass."';</script>";
	#성별
	if ($flagGender) {
		if ($myGender == 'm')
			echo "<script>document.getElementById('Gender').innerHTML = '남성';</script>";
		elseif ($myGender == 'f')
			echo "<script>document.getElementById('Gender').innerHTML = '여성';</script>";
		else
			echo "<script>document.getElementById('Gender').innerHTML = '-';</script>";
	}
	else
		echo "<script>document.getElementById('Gender').innerHTML = '-';</script>";
	#별명
	if ($myNick)
		echo "<script>document.getElementById('Nick').innerHTML = '".$myNick."';</script>";
	else
		echo "<script>document.getElementById('Nick').innerHTML = '-';</script>";
	#생년월일
	if ($myYear && $myMonth && $myDay)
		echo "<script>document.getElementById('Birth').innerHTML = '".$myYear."년 ".$myMonth."월 ".$myDay."일';</script>";
	else
		echo "<script>alert('생년월일을 입력해주세요'); location.href='".$link."';</script>";
	#이메일
	if ($myEmail_head && $myEmail_tail)
		echo "<script>document.getElementById('Email').innerHTML = '".$myEmail_head."@".$myEmail_tail."';</script>";
	else
		echo "<script>alert('이메일을 입력해주세요'); location.href='".$link."';</script>";
	#휴대전화
	if ($flagTel) {
		if ($myTel)
			echo "<script>document.getElementById('Tel').innerHTML = '".substr($myTel,0,3)."'+'-'+'".substr($myTel,3,4)."'+'-'+'".substr($myTel,7,4)."';</script>";
		else
			echo "<script>document.getElementById('Tel').innerHTML = '-';</script>";
	}
	else
		echo "<script>document.getElementById('Tel').innerHTML = '-';</script>";
	#소개
	if ($myIntro)
		echo "<script>document.getElementById('Intro').innerHTML = '".$myIntro."';</script>";
	else
		echo "<script>document.getElementById('Intro').innerHTML = '-';</script>";
	#프로필 사진
	$path = "./Upload/".$myProfile['name'];	
	if (move_uploaded_file($myProfile['tmp_name'], $path))
		echo "<script>document.getElementById('File').style.backgroundImage = \"url('".$path."')\";</script>";
	else 
		echo "<script>document.getElementById('File').innerHTML = '-';</script>";
	#본인확인질문
	if ($authQuest)
		echo "<script>document.getElementById('Ask').innerHTML = '".$authQuest."';</script>";
	else
		echo "<script>alert('본인확인질문을 선택해주세요 $authQuest'); location.href='".$link."';</script>";
	#본인확인답변
	if ($authReply)
		echo "<script>document.getElementById('Answer').innerHTML = '".$authReply."';</script>";
	else
		echo "<script>alert('본인확인답변을 입력해주세요'); location.href='".$link."';</script>";
?>
</html>