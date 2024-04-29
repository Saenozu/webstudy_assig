<html lang='ko'>
<?php
	session_start();
?>
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
	#Contents {
		width: 1260px;
		height: 580px;
		margin: 0 auto;
		margin-top: 50px;
		border: 15px double brown;
		border-radius: 5px;
		background-image: url('./Image/background.jpg');
		background-repeat: no-repeat;
		background-size: contain;
		padding: 10px;
	}
	#PlayUI {
		width: 100%;
		height: 50%;
		display: flex;
		justify-content: center;
	}
	#PrevWords {
		width: 100%;
		height: 15%;
		display: flex;
	}
	#History {
		width: 100%;
		height: 20%;
	}
	#InputArea {
		width: 100%;
		height: 15%;
		text-align: center;
		display : flex;
		justify-content : center;
		align-items : center;
	}
	#SAVE {
		width: 33%;
		height: 100%-30px;
		margin: 15px;
	}
	#EndWordBoard {
		width:33%;
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
	#LOAD {
		width: 33%;
		height: 100%-30px;
		margin: 15px;
	}
	.LoadSave {
		width: 50%;
		height: 70%;
		display: block;
		margin-top: 5%;
		margin-left: 0;
		font-size: 20px;
	}
	.wordBox {
		width: 20%;
		height: 60%;
		border-radius: 15px;
		margin: 10px;
		position: relative;
		background-color: rgba(0,0,0,0.7);
	}
	.words {
		color: #d9d9d9;
		text-align:center;
		margin: 0 auto;
		position: absolute;
		left: 50%; top: 50%;
		transform: translate(-50%, -50%);
	}
	#allWords {
		text-align: center;
		font-weight: bold;
		color: green;
		margin: 10px;
	}
	input[type=text] {
		width: 50%;
		height: 40%;
		font-size: 20px;
	}
	#ENTER {
		width: 15%;
		height: 40%;
		margin-left: 10px;
	}
</style>
<script>
	function addWords(words) {
		const arr = words.split(" ");
		var cnt;
		if (arr.length > 5) cnt = 5;
		else cnt = arr.length;
		for (var i = 0; i < cnt; i++) {
			document.getElementsByClassName('wordBox')[i].style.display = '';
			document.getElementsByClassName('words')[i].innerHTML = arr[arr.length-1-i];
		}
		console.log(arr.length);
	}
	function removeWords() {
		for (var i = 0; i < 5; i++) {
			document.getElementsByClassName('wordBox')[i].style.display = 'none';
			document.getElementsByClassName('words')[i].innnerHTML= '';
		}
	}
	function printHistory(words) {
		const arr = words.split(" ");
		const history = document.getElementById('allWords');
		for (var i = 0; i < arr.length; i++) {
			history.innerHTML += arr[i];
			if (i < arr.length-1) {
				history.innerHTML += " -> ";
			}
		}
		console.log(arr);
	}
	function printEndWord(word) {
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
<div id='Wrap'>
	<div id='Contents'>
		<form method='POST' action=''>
			<div id='PlayUI'>
				<div id='SAVE'>
				</div>
				<div id='EndWordBoard'>
					<p id='EndWord'>-</p>
				</div>
				<div id='LOAD'>
				</div>
			</div>
			<div id='PrevWords'>
				<div class='wordBox'><p class='words'></p></div>
				<div class='wordBox'><p class='words'></p></div>
				<div class='wordBox'><p class='words'></p></div>
				<div class='wordBox'><p class='words'></p></div>
				<div class='wordBox'><p class='words'></p></div>	
			</div>
			<div id='History'>
				<p id='allWords'></p>
			</div>
			<div id='InputArea'>
				<input type='text' name='text'/>
				<input type='submit' id='ENTER' name='submit' value='ENTER'/>
			</div>
		</form>
	</div>
</div>
</body>
<?php
	$myText = $_POST['text'];
	$first = iconv_substr($myText,0,1,"UTF-8");
	if (isset($_POST['submit'])){
		$history = array();
		if (isset($_SESSION['endWord'])){ #n번째 시도
			$cnt = $_SESSION['COUNT'];
			$history = explode(' ',$_SESSION['endWord']);
			
			$tmp = $history[$cnt-1];
			$len = iconv_strlen($tmp,"UTF-8");
			$end = iconv_substr($tmp, $len-1, 1,"UTF-8");
			
			#끝말잇기 성공
			if ($first == $end) { 
				$_SESSION['COUNT']++;
				$_SESSION['endWord'] = $_SESSION['endWord'].' '.$myText;
				echo "<script>removeWords(); addWords('".$_SESSION['endWord']."');</script>";
			}
			#끝말잇기 실패
			else { 
				$_SESSION['endWord'] = $myText;
				$_SESSION['COUNT'] = 1;
				echo "<script>removeWords(); addWords('".$myText."');</script>";
			}
			#중복 확인
			for ($i = 0; $i < $cnt; $i++) {
				if ($mytext == $history[$i]) { #끝말잇기 실패
					$_SESSION['endWord'] = $myText;
					$_SESSION['COUNT'] = 1;
					echo "<script>removeWords(); addWords('".$myText."'); </script>";
				}
			}
		}
		else { #첫번째 시도
			$_SESSION['endWord'] = $myText;
			$_SESSION['COUNT'] = 1;
			echo "<script>removeWords(); addWords('".$myText."'); </script>";
		}
		$len = iconv_strlen($myText,"UTF-8");
		$end = iconv_substr($myText, $len-1, 1,"UTF-8");
		echo "<script>printEndWord('".$end."'); printHistory('".$_SESSION['endWord']."');</script>";
	}
?>
</html>
