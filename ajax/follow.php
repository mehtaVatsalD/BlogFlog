<?php
	include_once('../dbconfig.php');
	$userName=$_GET['userName'];
	$bloggerName=$_GET['bloggerName'];
	$followCheck=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `follow` WHERE `following`='$bloggerName' AND `follower`='$userName'"));

	$totalFollowers=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT COUNT(`following`) FROM `follow` WHERE `following`='$bloggerName'"));
	$totalFollowers=$totalFollowers['COUNT(`following`)'];

	if($followCheck=="")
	{
		mysqli_query($dbase,"INSERT INTO `follow` VALUES ('$bloggerName','$userName')");
		$totalFollowers+=1;
		echo "<button type='button' onclick='followUser(\"$bloggerName\",\"$userName\")' class='buttons'>Unfollow</button>:$totalFollowers";
		$notificationText="$userName started following you.";
		mysqli_query($dbase,"INSERT INTO `notifications` (`notify`,`notifier`,`category`,`data`,`notification`) VALUES ('$bloggerName','$userName','follow','$userName','$notificationText')");
	}
	else
	{
		mysqli_query($dbase,"DELETE FROM `follow` WHERE `following`='$bloggerName' AND `follower`='$userName'");
		mysqli_query($dbase,"DELETE FROM `notifications` WHERE `category`='follow' AND `notify`='$bloggerName' AND `notifier`='$userName'");
		$totalFollowers-=1;
		echo "<button type='button' onclick='followUser(\"$bloggerName\",\"$userName\")' class='buttons'>Follow</button>:$totalFollowers";
	}
?>