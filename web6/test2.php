<?php
	include('./test1.php');
	$query = "select * from Old_Member";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			print_r($row);
			echo $row['School'];
			echo "<br>";
		}
	}
?>
