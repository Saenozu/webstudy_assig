<html>
<head>
	<title>ex1</title>
</head>
<body>
<form method='post' action=''>
이름: <input type='text' name='name'/> <br>
나이: <input type='text' name='age'/> <br>
<input type='submit' name='submit'/>
</form>
<?php
	include('./test1.php');
	$name = $_POST['name'];
	$age = $_POST['age'];
	
	$query = "insert into test_table (name, age) values ('".$name."', '".$age."')";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			print_r($row);
			echo "<br>";
		}
	}
?>
</body>
</html>

