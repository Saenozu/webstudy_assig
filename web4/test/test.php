<?php
	$str1 = "CAT-Security";
	$str2 = "CAT-CERT";

	if(ereg($str1, "cat-security"))
		echo "pattern fined! (1) <br>";

	if(ereg($str1, "cat-security"))
		echo "pattern fined! (2) <br>";

	$catToDog = eregi_replace("cat","dog",$str2);
	echo "replace : ".$catToDog."<br>";
?>
