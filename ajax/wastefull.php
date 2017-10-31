<?php
	session_start();
	include_once('../dbconfig.php');
	$blogid=$_GET['blogid'];
	$user=$_SESSION['login'];
	$wastefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `wastefull` WHERE `userName`='$user' AND `id`='$blogid'"));

	$totalUsefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `usefull` FROM `blogs` WHERE `id`='$blogid' "));
	$totalUsefull=$totalUsefull['usefull'];

	$totalWastefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `wastefull` FROM `blogs` WHERE `id`='$blogid' "));
	$totalWastefull=$totalWastefull['wastefull'];

	if($wastefull=="")
	{
		$usefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `usefull` WHERE `userName`='$user' AND `id`='$blogid'"));
		if($usefull!="")
		{
			mysqli_query($dbase,"DELETE FROM `usefull` WHERE `id`='$blogid' AND `userName`='$user'");
			$totalUsefull-=1;
			mysqli_query($dbase,"UPDATE `blogs` SET `usefull`='$totalUsefull' WHERE `id`='$blogid' ");
		}
		mysqli_query($dbase,"INSERT INTO `wastefull` VALUES ('$blogid','$user') ");
		$totalWastefull+=1;
		mysqli_query($dbase,"UPDATE `blogs` SET `wastefull`='$totalWastefull' WHERE `id`='$blogid' ");

		echo "<span onclick='usefullPost(".$blogid.",this)'><i class='fa fa-thumbs-up'></i> Usefull&nbsp;&nbsp;$totalUsefull</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='wastefull' onclick='wastefullPost(".$blogid.",this)'><i class='fa fa-thumbs-down'></i> Waste of Time&nbsp;&nbsp;$totalWastefull</span>";
	}
	else
	{
		mysqli_query($dbase,"DELETE FROM `wastefull` WHERE `id`='$blogid' AND `userName`='$user'");
		$totalWastefull-=1;
		mysqli_query($dbase,"UPDATE `blogs` SET `wastefull`='$totalWastefull' WHERE `id`='$blogid' ");

		echo "<span onclick='usefullPost(".$blogid.",this)'><i class='fa fa-thumbs-up'></i> Usefull&nbsp;&nbsp;$totalUsefull</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onclick='wastefullPost(".$blogid.",this)'><i class='fa fa-thumbs-down'></i> Waste of Time&nbsp;&nbsp;$totalWastefull</span>";
	}
?>