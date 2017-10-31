<?php
	include_once('../dbconfig.php');
	$blogid=$_GET['blogid'];

	$blogger=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `blogger` FROM `blogs` WHERE `id`='$blogid'"));
	$blogger=$blogger['blogger'];

	if($blogger!=$admin)
	{
		$notificationText="$admin found your blog inappropiate for blogFlog users and hence your blog is deleted.Try posting some usefull blogs.";
		mysqli_query($dbase,"INSERT INTO `notifications` (`notify`,`notifier`,`category`,`data`,`notification`) VALUES ('$blogger','$admin','delete','0','$notificationText')");
	}

	mysqli_query($dbase,"DELETE FROM `blogs` WHERE `id`='$blogid'");
	mysqli_query($dbase,"DELETE FROM `comments` WHERE `id`='$blogid'");
	mysqli_query($dbase,"DELETE FROM `notifications` WHERE `data`='$blogid'");
	mysqli_query($dbase,"DELETE FROM `usefull` WHERE `id`='$blogid'");
	mysqli_query($dbase,"DELETE FROM `wastefull` WHERE `id`='$blogid'");

?>