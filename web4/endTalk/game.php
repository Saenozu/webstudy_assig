<?php
	session_start();
	$myText = $_POST['text']; #뒷단어
	$first = iconv_substr($myText,0,1,"UTF-8"); #뒷단어 첫글자
	
	# Press save
	if (isset($_POST['save'])) {
		$wordCount = $_SESSION['Count'];
		$allWords = $_SESSION['endWord'];
		# Make Cookie
		setcookie("saveCnt",$wordCount, time() + 10 * 60);
		setcookie("saveWords",$allWords, time() + 10 * 60);
		
		if (isset($_SESSION['Count']))
			echo "<script>alert('저장했습니다!');</script>";
		# Save data
		else echo "<script> alert('저장할 데이터가 없습니다!');</script>";
	}
	# Press load
	if (isset($_POST['load'])) {
		# Have load data
		if (isset($_COOKIE['saveWords'])) {
			$_SESSION['Count'] = $_COOKIE['saveCnt'];
			$_SESSION['endWord'] = $_COOKIE['saveWords'];
			echo "<script>alert('불러왔습니다!');</script>";
		}
		# No load data
		else echo "<script>alert('불러올 데이터가 없습니다!');</script>";
	}
?>
<html lang='ko'>
<head>
<meta charset='UTF-8'>
<title>끝말잇기</title>
<style>
	@font-face {
		font-family: 'BMEuljiro10yearslater';
		src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_20-10-21@1.0/BMEuljiro10yearslater.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}
	@font-face {
		font-family: 'LeeSeoyun';
		src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2202-2@1.0/LeeSeoyun.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}
	body {
		background: url('./Image/backPattern.png') center/contain;
		position: relative;
	}
	#Contents {
		width: 800px;
		height: 500px;
		margin: 0 auto;
		border: 10px solid #025940;
		background-color: #03A64A;
		padding-left: 10px;
		padding-right: 10px;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
	}
	#PlayUI {
		width: 100%;
		height: 60%;
		display: flex;
		justify-content: center;
	}
	#PrevWords {
		width: 100%-10px;
		height: 15%;
		display: flex;
		align-items: center;
		background-color: rgba(255,255,255,0.2);
		border: 5px dotted #025940;
	}
	#InputArea {
		width: 100%;
		height: 25%;
		text-align: center;
		display : flex;
		justify-content : center;
		align-items : center;
	}
	#UI_SAVE {
		width: 25%;
		height: 100%-30px;
		margin: 15px;
		text-align: center;
		position: relative;
	}
	#SAVE {
		width: 120px;
		height: 120px;
		border: none;
		color: white;
		font-family: 'LeeSeoyun';
		font-weight: bold;
		font-size: 20px;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
		background: url('./Image/button.png') center/contain no-repeat;
	}
	#UI_LOAD {
		width: 25%;
		height: 100%-30px;
		margin: 15px;
		text-align: center;
		position: relative;
	}
	#LOAD {
		width: 120px;
		height: 120px;
		border: none;
		color: white;
		font-family: 'LeeSeoyun';
		font-weight: bold;
		font-size: 20px;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
		background: url('./Image/button.png') center/contain no-repeat;
	}
	#EndWordBoard {
		width: 50%;
		position: relative;
		background-image: url('./Image/greenBoard.png');
		background-size: contain;
		background-position: center;
		background-repeat: no-repeat;
	}
	#EndWord {
		font-family: BMEuljiro10yearslater;
		color: #fff;
		font-size:50px;
		text-align:center;
		margin: 0 auto;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
	}
	
	.LoadSave {
		width: 50%;
		height: 70%;
		display: block;
		margin-top: 5%;
		margin-left: 0;
		font-size: 20px;
	}
	.wordArea {
		width: 20%;
		height: 100%;
	}
	.wordBox {
		width: 100%-10px;
		height: 60%;
		border-radius: 15px;
		margin: 10px;
		margin-top: 15px;
		position: relative;
		background-color: rgba(0,0,0,0.7);
	}
	.words {
		color: #d9d9d9;
		text-align:center;
		font-family: 'LeeSeoyun';
		margin: 0 auto;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
	}
	input[type=text] {
		font-family: 'LeeSeoyun';
		width: 70%;
		height: 30%;
		text-align: center;
		font-size: 18px;
	}
	#ENTER {
		font-family: 'LeeSeoyun';
		font-size: 18px;
		width: 15%;
		height: 30%;
		margin-left: 20px;
	}
</style>
<script>
	function pressEnter() {
		document.getElementById('ENTER').click();
	}
	function addWords(words) { //최근 5글자 출력
		const arr = words.split(" ");
		var cnt;
		if (arr.length > 5) cnt = 5;
		else cnt = arr.length;
		if (words) {
			for (var i = 0; i < cnt; i++) {
				document.getElementsByClassName('words')[i].innerHTML = arr[arr.length-1-i];
				document.getElementsByClassName('wordArea')[i].style.display = '';
				document.getElementsByClassName('wordBox')[i].style.display = '';
			}
		}
	}
	function removeWords() { //박스 비활성화
		for (var i = 0; i < 5; i++) {
			document.getElementsByClassName('words')[i].innnerHTML= '';
			document.getElementsByClassName('wordArea')[i].style.display = 'none';
			document.getElementsByClassName('wordBox')[i].style.display = 'none';
		}
	}
	function printEndWord(word) { //칠판에 뒷글자 출력
		const lastWord = document.getElementById('EndWord');
		if (word) {
			lastWord.innerHTML = word;
		}
		else {
			lastWord.innerHTML = "-";
		}
	}
</script>
</head>
<body>
<div id='Contents'>
	<form method='POST' action=''>
		<div id='PlayUI'>
			<div id='UI_SAVE'>
				<input type='submit' id='SAVE' name='save' value='SAVE' />
			</div>
			<div id='EndWordBoard'>
				<!--마지막단어 끝글자-->
				<p id='EndWord'>-</p> 
			</div>
			<div id='UI_LOAD'>
				<input type='submit' id='LOAD' name='load' value='LOAD'/>
			</div>
		</div>
		<div id='PrevWords'>
			<!--이전 5개 단어-->
			<div class='wordArea'><div class='wordBox'><p class='words'></p></div></div>
			<div class='wordArea'><div class='wordBox'><p class='words'></p></div></div>
			<div class='wordArea'><div class='wordBox'><p class='words'></p></div></div>
			<div class='wordArea'><div class='wordBox'><p class='words'></p></div></div>
			<div class='wordArea'><div class='wordBox'><p class='words'></p></div></div>	
		</div>
		<div id='InputArea'>
			<input type='text' name='text' onkeypress="if(event.keyCode=='13'){event.preventDefault(); pressEnter();}" autofocus />
			<input type='submit' id='ENTER' name='submit' value='ENTER  ↵'/>
		</div>
	</form>
</div>
</body>
</html>
<?php
	$history = explode(" ",$_SESSION['endWord']); #입력한 단어 배열
	
	if (isset($_POST['save']) | isset($_POST['load'])) {
		$lastWord = end($history);
		$len = iconv_strlen($lastWord,'UTF-8');
		$lastLetter = iconv_substr($lastWord, $len-1, 1,'UTF-8');
		echo "<script>removeWords(); addWords('".$_SESSION['endWord']."');";
		echo "printEndWord('".$lastLetter."');</script>";
	}
	
	if (isset($_POST['submit'])){
		if (isset($_SESSION['endWord'])){ #n번째 시도
			$cnt = $_SESSION['Count']; 
			
			$lastWord = end($history);
			$len = iconv_strlen($lastWord,"UTF-8"); #앞단어 길이
			$lastLetter = iconv_substr($lastWord, $len-1, 1,"UTF-8"); #앞단어 마지막글자
			
			#중복 확인
			for ($i = 0; $i < $cnt; $i++) {
				if ($myText == $history[$i]) { #끝말잇기 실패
					$_SESSION['endWord'] = $myText;
					$_SESSION['Count'] = 1;
					$flag = 1;
				}
			}
			
			if ($flag == 0) {
				#끝말잇기 성공
				if ($first == $lastLetter) { 
					$_SESSION['Count']++;
					$_SESSION['endWord'] = $_SESSION['endWord'].' '.$myText;
					echo "<script>removeWords(); addWords('".$_SESSION['endWord']."');</script>";
				}
				#끝말잇기 실패
				else { 
					$_SESSION['endWord'] = $myText;
					$_SESSION['Count'] = 1;
					echo "<script>removeWords(); addWords('".$myText."');</script>";
				}
			} else echo "<script>removeWords(); addWords('".$myText."');</script>";
		}
		else { #첫번째 시도
			$_SESSION['endWord'] = $myText;
			$_SESSION['Count'] = 1;
			echo "<script>removeWords(); addWords('".$myText."'); </script>";
		}
		
		$len = iconv_strlen($myText,"UTF-8");
		$end = iconv_substr($myText, $len-1, 1,"UTF-8");
		echo "<script>printEndWord('".$end."');</script>";
	}
?>
