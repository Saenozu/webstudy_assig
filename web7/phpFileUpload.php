<html>
<head>
	<title>File Upload</title>
</head>
<body>
	<form method="post" action="" enctype='multipart/form-data'>
		<input type='file' name='uploadfile'/>
		<input type='submit' value='upload' name='upload'/>
	</form>
</body>
</html>
<?php
	$file = $_FILES['uploadfile'];
	echo "파일이름: ".$file['name']."<br>";
	echo "파일크기: ".$file['size']."<br>";
	echo "임시저장: ".$file['tmp_name']."<br>";
	$path = "./upload/";
	
	if ($_POST['upload'] == "upload") {
		if (move_uploaded_file($file['tmp_name'],$path.$file['name'])){
			echo "Upload success!";
		}
		else {
			echo "Upload fail..";
		}
	}
?>
