<?php
	setcookie("myCookie", "cookieValue", time() + (60 * 60 * 24));
	echo $_COOKIE['myCookie'];
?>
