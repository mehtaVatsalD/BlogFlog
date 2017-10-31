<?php
session_start();
include_once('dbconfig.php');
if (!isset($_SESSION['login'])) {
	header('location:index.php');
}
$userName=$_SESSION['login'];
$bloggerName=$_GET['user'];
if (isset($_GET['follow'])) {
	$userLogged=$_SESSION['login'];
	mysqli_query($dbase,"INSERT INTO `follow` VALUES ('$bloggerName','$userLogged')");
	header("location:profile.php?user=".$bloggerName);
}
elseif (isset($_GET['unfollow'])) {
	$userLogged=$_SESSION['login'];
	mysqli_query($dbase,"DELETE FROM `follow` WHERE `following`='$bloggerName' AND `follower`='$userLogged'");
	header("location:profile.php?user=".$bloggerName);
}
$blockStatus=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `block` FROM `users` WHERE `userName`='$userName'"));
$blockStatus=$blockStatus['block'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>BlogFlog</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
	<link rel="stylesheet" href="vendor/fonts/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
	<?php include_once('header.php'); ?>
	<?php
	$bloggerData=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `users` WHERE `userName`='$bloggerName'"));
	$mail=$bloggerData['mail'];
	$propic=$bloggerData['propic'];
	$location='propics/'.$propic;
	$userName=$_SESSION['login'];
	$followCheck=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `follow` WHERE `following`='$bloggerName' AND `follower`='$userName'"));
	if($followCheck=="")
	{
		// $followButton="<form action='profile.php' method='GET'><input type='hidden' value='$bloggerName' name='user'><button type='submit' class='buttons' name='follow' value='$bloggerName'>Follow <i class='fa fa-plus'></i></button></form>";
		$followButton="<button type='button' onclick='followUser(\"$bloggerName\",\"$userName\")' class='buttons'>Follow</button>";
	}
	else
	{
		$followButton="<button type='button' onclick='followUser(\"$bloggerName\",\"$userName\")' class='buttons'>Unfollow</button>";
	}
	$totalFollowers=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT COUNT(`following`) FROM `follow` WHERE `following`='$bloggerName'"));
	$totalFollowers=$totalFollowers['COUNT(`following`)'];

	$totalFollowing=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT COUNT(`follower`) FROM `follow` WHERE `follower`='$bloggerName'"));
	$totalFollowing=$totalFollowing['COUNT(`follower`)'];

	$totalPosts=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT COUNT(`id`) FROM `blogs` WHERE `blogger`='$bloggerName'"));
	$totalPosts=$totalPosts['COUNT(`id`)'];
	?>
	<div class="row userInfo">
		<div class="col-3">
			<img src="<?php echo $location; ?>">
		</div>
		<div class="col-9">
			<table cellspacing="10">
				<tr>
					<td colspan="2"><?php echo "<span class='profileTitle'>$bloggerName</span>" ?></td>
					<?php 
						if($bloggerName!=$userName && $bloggerName!=$admin && $userName!=$admin)
							echo "<td class=\"followParent\">$followButton</td>";
						elseif($userName==$admin && $bloggerName!=$admin)
						{
							$blockStatus=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `block` FROM `users` WHERE `userName`='$bloggerName'"));
							$blockStatus=$blockStatus['block'];
							if($blockStatus==0)
							{
								echo "<td class\"followParent\"><button type='button' onclick='blockUser(\"$bloggerName\")' class='buttons'>Block</button></td>";
							}
							else
							{
								echo "<td class\"followParent\"><button type='button' onclick='blockUser(\"$bloggerName\")' class='buttons'>Unblock</button></td>";
							}
						}
					 ?>
					<!-- class='followButton' -->
				</tr>
				<tr>
					<td colspan="3"><?php echo "<span class='userMail'>$mail</span>" ?></td>
				</tr>
				<?php
					if($bloggerName!=$admin)
					{
						echo "
							<tr class=\"postCountTitle\">
								<td>Followers</td>
								<td>Following</td>
								<td>Posts</td>
								<!-- <td>Usefull Count</td>
								<td>Waste of Time Count</td>
								<td>Comments on Posts</td> -->
							</tr>
							<tr class=\"postCounts\">
								<td class=\"followerPanel\">$totalFollowers</td>
								<td class=\"followingPanel\">$totalFollowing</td>
								<td>$totalPosts</td>
							</tr>
						";
					}
				?>
							
							
			</table>
		</div>
	</div>
	<hr>
	<div class="container">
	<?php
		// $blogFollowers=mysqli_query($dbase,"");
		$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `blogger`='$bloggerName' ORDER BY `time` DESC LIMIT 2");
		$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`id`) FROM `blogs` WHERE `blogger`='$bloggerName'"));
		$minDbId=$minDbId['MIN(`id`)'];
		$userName=$_SESSION['login'];
		$flag=0;
		while($blog=mysqli_fetch_assoc($blogsToShow))
		{
			$flag=1;
			$minId=$blog['id'];
			$blogid=$blog['id'];
			$blogger=$blog['blogger'];
			$title=$blog['title'];
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
				// echo "

				// <div class='row'>
				// 	<div class='col-12 blogPosts'>
				// 		<i class='fa fa-window-close deleteBtn'></i>
				// 		<img src='$location'>
				// 		<span class='blogWriter'>".$blogger."</span>
				// 		<div class='mainContent'>".$blog['blog']."</div>
				// 		<div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div>
				// 	</div>
				// </div>

				// ";

				$postToPrint="
				<div class='row'>
					<div class='col-12 blogPosts'>";
				if($userName==$admin)
				{
					$postToPrint.="<i class='fa fa-window-close deleteBtn' onclick='takeDelConf($blogid)'></i>";
				}
				else if ($userName==$blogger) {
					$postToPrint.="<i class='fa fa-pencil editBtn' onclick='showEditPopup($blogid)'></i>";
				}
				$postToPrint.="
						<a href=\"profile.php?user=$blogger\"><img src='$location'>
						<span class='blogWriter'>".$blogger."</span></a>
						<div class='blogTitles blogTitles$blogid'>".$title."</div><hr>
						<div class=\"mainContent mainContent$blogid\">".$blog['blog']."</div><hr>
						<div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div><br>
						<a href='detailPost.php?blogid=".$blogid."' class='viewAllComments'>See All Details</a>
						<div>$showCommentTable</div>";
				if($blockStatus==0)
				{
					$postToPrint.="
						<div class='commentPlz'><img src='$locationProfilePic'><input class='commentInput' type='text' placeholder='Enter Your Comment...' onkeyup='checkEnterPress(event,".$blogid.")'><input type='submit' class='buttons commentBtn' value='Comment' onclick='commentPlz(".$blogid.")'></div>";
				}
				$postToPrint.=	"
					</div>
				</div>";
				echo "$postToPrint";



				// echo "

				// <div class='row'>
				// 	<div class='col-12 blogPosts'>
				// 		<img src='$location'>
				// 		<span class='blogWriter'>".$blogger."</span>
				// 		<div class='mainContent'>".$blog['blog']."</div>
				// 		<div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div><hr>
				// 		<a href='detailPost.php?blogid=".$blogid."' class='viewAllComments'>View All Comments</a>
				// 		<div>$showCommentTable</div>
				// 		<div class='commentPlz'><img src='$locationProfilePic'><input class='commentInput' type='text' placeholder='Enter Your Comment...' onkeyup='checkEnterPress(event,".$blogid.")'><input type='submit' class='buttons commentBtn' value='Comment' onclick='commentPlz(".$blogid.")'></div>
				// 	</div>
				// </div>

				// ";
		}
		if(isset($minId) && $minDbId<$minId)
		{
			echo "<div class=\"viewMore\" onclick=\"viewMore($minId,$minDbId,'profile','$bloggerName')\">View More</div>";
		}
		if($flag==0)
		{
			echo "
			<div class=\"row\">
				<div class=\"col-12 recommendParent\">
					<div class=\"recommendChild\">";
			$recommends=mysqli_query($dbase,"SELECT * FROM `users` WHERE `userName` NOT IN (SELECT `following` FROM `follow` WHERE `follower`='$userName') AND `userName`<>'$userName' AND `userName`<>'$admin'");
			while($recommend=mysqli_fetch_assoc($recommends))
			{
				$flag++;
				$blogger=$recommend['userName'];
				$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$blogger'"));
				$location='propics/'.$propic['propic'];
				echo "
				<div class=\"recommendCards\">
					<a href=\"profile.php?user=$blogger\">
						<img src=\"$location\">
						<p>$blogger</p>
					</a>
				</div>";
			}
			if($flag<5)
			{
				echo "
				<div class=\"recommendCards\">
					<p class=\"shortagePara\">Recommend BlogFlog to your friends...</p>
				</div>";
			}
			echo "
					</div>
				</div>
			</div>
			";
		}

	?>
	</div>
	<div class="deleteConf"></div>
<div class="deleteCont">
	<span>Are you sure you want to delete this post?</span>
	<div>
		<button type="button" class="buttons deleteSubmit">Delete</button>
		<button type="button" class="buttons" onclick='completeDeleting()'>Cancel</button>
	</div>
</div>
<div class="blackback" onclick="hideEditPopup()"></div>
<div class="editProfile blogEditor">
	<?php echo "
			<input type=\"text\" name=\"title\" class=\"postTitle\" id=\"editTitle\" placeholder=\"Enter Title for your Blog\">
			<textarea placeholder=\"Write Your Blog Post Here...\" id=\"editPost\" onkeyup=\"handleHeight(this,50)\" maxlength=\"10000\" class=\"postContent\"></textarea>
			<button type=\"button\" id='editPostBtn' class=\"buttons\">Post</button>
			<button type='button' class='buttons' onclick='hideEditPopup()'>Cancel</button>
	";?>
</div>
</body>
<script type="text/javascript" src="js/restapis.js"></script>
</html>