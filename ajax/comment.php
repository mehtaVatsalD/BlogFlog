<?php
	session_start();
	include_once('../dbconfig.php');
	$loggedUser=$_SESSION['login'];
	$comment=addslashes($_POST['comment']);
	$blogid=$_POST['blogid'];
	if($comment!="")
	{
		mysqli_query($dbase,"INSERT INTO `comments` (`id`,`commenter`,`comment`) VALUES ('$blogid','$loggedUser','$comment')");
		$userData=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `users` WHERE `userName`='$loggedUser'"));
		$locationProfilePic=$userData['propic'];
		$comment=stripslashes($_POST['comment']);
		$returnString="
		<table class='showCommentTable'>
			<tr>
			<td><img src='propics/$locationProfilePic'></td>
			<td><span>$loggedUser</span><br>$comment</td>
			</tr>
		</table>
		";

		$blogger=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `blogger` FROM `blogs` WHERE `id`='$blogid'"));
		$blogger=$blogger['blogger'];
		if($blogger!=$loggedUser)
		{
			$notificationText="$loggedUser commented on your Blog...\"$comment\"";
			mysqli_query($dbase,"INSERT INTO `notifications` (`notify`,`notifier`,`category`,`data`,`notification`) VALUES ('$blogger','$loggedUser','comment','$blogid','$notificationText')");
		}
			
		echo $returnString;
	}

?>
