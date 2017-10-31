<?php
	$minId=$_GET['minId'];
	$minDbId=$_GET['minDbId'];
	$page=$_GET['page'];
	$bloggerName='';
	if($page=="main" || $page=="profile")
	{
		session_start();
	}
	include_once('../dbconfig.php');
	if($page=="main" || $page=="profile")
	{
		$userName=$_SESSION['login'];
		$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$userName'"));
		$propic=$propic['propic'];
		$locationProfilePic='propics/'.$propic;
		$blockStatus=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `block` FROM `users` WHERE `userName`='$userName'"));
		$blockStatus=$blockStatus['block'];
	}
	if($page=='main')
	{
		if($userName==$admin)
		{
			$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `id`<'$minId' ORDER BY `time` DESC LIMIT 2");
			$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`id`) FROM `blogs` WHERE 1"));
			$minDbId=$minDbId['MIN(`id`)'];
		}
		else
		{
			$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE (`blogger` IN (SELECT `following` FROM `follow` WHERE `follower`='$userName') OR `blogger`='$userName' OR `blogger`='$admin') AND `id`<'$minId' ORDER BY `time` DESC LIMIT 2");
			$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`id`) FROM `blogs` WHERE `blogger` IN (SELECT `following` FROM `follow` WHERE `follower`='$userName') OR `blogger`='$userName' OR `blogger`='$admin'"));
			$minDbId=$minDbId['MIN(`id`)'];
		}
	}
	else if ($page=='profile') {
		$bloggerName=$_GET['bloggerName'];
		$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `blogger`='$bloggerName' AND `id`<'$minId' ORDER BY `time` DESC LIMIT 2");
	}
	else if($page=='index')
	{
		$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE 1 ORDER BY `usefull` DESC LIMIT 2 OFFSET ".$minId);
		$minId+=$minId;
	}
	while($blog=mysqli_fetch_assoc($blogsToShow))
	{
		if($page=='main' || $page=='profile')
			$minId=$blog['id'];
		$blogid=$blog['id'];
		$title=$blog['title'];
		$blogger=$blog['blogger'];
		$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$blogger'"));
		$location='propics/'.$propic['propic'];
		if($page=='profile' || $page=='main')
		{
			$isUsefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `usefull` WHERE `id`='$blogid' AND `userName`='$userName'"));
			if($isUsefull=="")
			{
				$usefullSpan="<span onclick='usefullPost(".$blogid.",this)'><i class='fa fa-thumbs-up'></i> Usefull&nbsp;&nbsp;".$blog['usefull']."</span>";
			}
			else
			{
				$usefullSpan="<span class='usefull' onclick='usefullPost(".$blogid.",this)'><i class='fa fa-thumbs-up'></i> Usefull&nbsp;&nbsp;".$blog['usefull']."</span>";	
			}

			$isWastefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `wastefull` WHERE `id`='$blogid' AND `userName`='$userName'"));
			if($isWastefull=="")
			{
				$wastefullSpan="<span onclick='wastefullPost(".$blogid.",this)'><i class='fa fa-thumbs-down'></i> Waste of Time&nbsp;&nbsp;".$blog['wastefull']."</span>";
			}
			else
			{
				$wastefullSpan="<span class='wastefull' onclick='wastefullPost(".$blogid.",this)'><i class='fa fa-thumbs-down'></i> Waste of Time&nbsp;&nbsp;".$blog['wastefull']."</span>";	
			}
			$topComment=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MAX(`time`) FROM `comments` WHERE `id`='$blogid'"));
			$topComment=$topComment['MAX(`time`)'];
			$topComment=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `comments` WHERE `id`='$blogid' AND `time` = '$topComment'"));
			
			$commenter=$topComment['commenter'];
			$commenterData=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `users` WHERE `userName`='$commenter'"));
			$commenterPic=$commenterData['propic'];

			$topComment=$topComment['comment'];
			if ($topComment!="") {
				$showCommentTable = "
			<table class='showCommentTable'>
				<tr>
				<td><img src='propics/$commenterPic'></td>
				<td><span>$commenter</span><br>$topComment</td>
				</tr>
			</table>
			";	
			}
			else
			{
				$showCommentTable="";
			}
		}

		$postToPrint="
		<div class='row'>
			<div class='col-12 blogPosts'>";
		if($page=='profile' || $page=='main')
		{
			if($userName==$admin)
			{
				$postToPrint.="<i class='fa fa-window-close deleteBtn' onclick='takeDelConf($blogid)'></i>";
			}
			else if ($userName==$blogger) {
				$postToPrint.="<i class='fa fa-pencil editBtn' onclick='showEditPopup($blogid)'></i>";
			}
			$postToPrint.="<a href=\"profile.php?user=$blogger\">";
		}
		$postToPrint.="
				<img src='$location'>
				<span class='blogWriter'>".$blogger."</span>";
		if($page=='profile' || $page=='main')
		{
			$postToPrint.="</a>";
		}

		$postToPrint.=
				"<div class='blogTitles blogTitles$blogid'>".$title."</div><hr>
						<div class=\"mainContent mainContent$blogid\">".$blog['blog']."</div>";

		if($page=='profile' || $page=='main')
		{

			$postToPrint.=
				"<hr><div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div><br>
				<a href='detailPost.php?blogid=".$blogid."' class='viewAllComments'>See All Details</a>
				<div>$showCommentTable</div>";

				if($blockStatus==0)
				{
					$postToPrint.="
						<div class='commentPlz'><img src='$locationProfilePic'><input class='commentInput' type='text' placeholder='Enter Your Comment...' onkeyup='checkEnterPress(event,".$blogid.")'><input type='submit' class='buttons commentBtn' value='Comment' onclick='commentPlz(".$blogid.")'></div>";
				}
		}

		$postToPrint.=
			"</div>
		</div>";
		echo "$postToPrint";
	}
	if ($page=='main' || $page=='profile') {
		if ($minDbId<$minId) {
			echo "<div class=\"viewMore\" onclick=\"viewMore($minId,$minDbId,'$page','$bloggerName')\">View More</div>";	
		}
	}
	else{
		if ($minDbId>$minId) {
			echo "<div class=\"viewMore\" onclick=\"viewMore($minId,$minDbId,'$page','$bloggerName')\">View More</div>";	
		}
	}
		

?>