<?php
	include("./my_sum.php");
	require("./my_name.php");

	$a = $_POST['a'];
	$b = $_POST['b'];
	$c = sum($a,$b);
	echo $var."'s sum function";

	if($_POST['submit'] != NULL)
		printf("<br>%d + %d = %d", $a, $b, $c);
	else {
		?>
		<form method="POST" action="">
			<input type="text" name="a">
			<input type="text" name="b">
			<input type="submit" name="submit" value="hi">
		</form>
		<?php
	}
?>
