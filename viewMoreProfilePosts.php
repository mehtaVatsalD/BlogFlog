<?php
	session_start();
	include_once('../dbconfig.php');
	$userName=$_SESSION['login'];
	$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$userName'"));
	$propic=$propic['propic'];
	$locationProfilePic='propics/'.$propic;
	$minId=$_GET['minId'];
	$minDbId=$_GET['minDbId'];
	$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `blogger`='$bloggerName' ORDER BY `time` DESC LIMIT 2");
	while($blog=mysqli_fetch_assoc($blogsToShow))
			{
				$minId=$blog['id'];
				$blogid=$blog['id'];
				$title=$blog['title'];
				$blogger=$blog['blogger'];
				$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$blogger'"));
				$location='propics/'.$propic['propic'];
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

				$postToPrint="
				<div class='row'>
					<div class='col-12 blogPosts'>";
				if($userName==$admin)
				{
					$postToPrint.="<i class='fa fa-window-close deleteBtn' onclick='takeDelConf($blogid)'></i>";
				}
				$postToPrint.="
						<img src='$location'>
						<span class='blogWriter'>".$blogger."</span>
						<div class='blogTitles'>".$title."</div><hr>
						<div class='mainContent'>".$blog['blog']."</div><hr>
						<div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div><br>
						<a href='detailPost.php?blogid=".$blogid."' class='viewAllComments'>View All Comments</a>
						<div>$showCommentTable</div>
						<div class='commentPlz'><img src='$locationProfilePic'><input class='commentInput' type='text' placeholder='Enter Your Comment...' onkeyup='checkEnterPress(event,".$blogid.")'><input type='submit' class='buttons commentBtn' value='Comment' onclick='commentPlz(".$blogid.")'></div>
					</div>
				</div>";
				echo "$postToPrint";
			}
			if ($minDbId<$minId) {
				echo "<div class=\"viewMore\" onclick=\"viewMore($minId,minDbId)\">View More</div>";	
			}

?>