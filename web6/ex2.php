<html lang='ko'>
<head>
<meta charset='utf-8'>
<title>ex2</title>
</head>
<body>
<?php include('./test1.php');?>
	<table border=1 width=100%>
	<tr>
		<td>이름</td>
		<td>학교</td>
		<td>학과</td>
		<td>성별</td>
		<td>입학년도</td>
		<td>이메일</td>
		<td>전화번호</td>
		<td>생일</td>
		<td>학년</td>
		<td>학점</td>
	<tr>
<?php
	
	$query = "select * from Old_Member";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr> <td>"
				.$row['Name']."</td><td>"
				.$row['School']."</td><td>"
				.$row['Major']."</td><td>"
				.$row['Gender']."</td><td>"
				.$row['EnterYear']."</td><td>"
				.$row['Email']."</td><td>"
				.$row['Phone']."</td><td>"
				.$row['Birth']."</td><td>"
				.$row['Grade']."</td><td>"
				.$row['Score']."</td> </tr>";
		}
	}
	$query = "select * from New_Member";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr> <td>"
				.$row['Name']."</td><td>"
				.$row['School']."</td><td>"
				.$row['Major']."</td><td>"
				.$row['Gender']."</td><td>"
				.$row['EnterYear']."</td><td>"
				.$row['Email']."</td><td>"
				.$row['Phone']."</td><td>"
				.$row['Birth']."</td><td>"
				.$row['Grade']."</td><td>"
				.$row['Score']."</td> </tr>";
		}
	}
?>
	</table>
</body>
</html>
