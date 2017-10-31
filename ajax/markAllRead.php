<?php
	session_start();
	include_once('../dbconfig.php');
	$loggedUser=$_SESSION['login'];
	mysqli_query($dbase,"UPDATE `notifications` SET `readby`='1' WHERE `notify`='$loggedUser'");
	echo "<i class=\"fa fa-bell notifySymbol \" onclick='showNotificationPanel()'>0</i>";;
?>