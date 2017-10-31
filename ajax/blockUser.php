<?php
	include_once('../dbconfig.php');
	$bloggerName=$_GET['bloggerName'];
	$blockStatus=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `block` FROM `users` WHERE `userName`='$bloggerName'"));
	$blockStatus=$blockStatus['block'];
	if($blockStatus==0)
	{
		mysqli_query($dbase,"UPDATE `users` SET `block`='1' WHERE `userName`='$bloggerName'");
		echo "<button type='button' onclick='blockUser(\"$bloggerName\")' class='buttons'>Unblock</button>";
	}
	else
	{
		mysqli_query($dbase,"UPDATE `users` SET `block`='0' WHERE `userName`='$bloggerName'");
		echo "<button type='button' onclick='blockUser(\"$bloggerName\")' class='buttons'>Block</button>";
	}
?>