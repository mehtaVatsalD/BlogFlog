<?php
session_start();
include_once('dbconfig.php');
if (!isset($_SESSION['login'])) {
	header('location:index.php');
}
$userName=$_SESSION['login'];
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
	<?php include_once('header.php') ?>
	<div class="container">
		
		<?php
			if(isset($_GET['blogid']) && $_GET['blogid']!=0)
			{
				$blogid=$_GET['blogid'];
				$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `id`='$blogid'");
				while($blog=mysqli_fetch_assoc($blogsToShow))
				{
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
					$comments=mysqli_query($dbase,"SELECT * FROM `comments` WHERE `id`='$blogid'");
					$showCommentTable="";
					while($comment=mysqli_fetch_assoc($comments))
					{
						$commenter=$comment['commenter'];
						$commenterData=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT * FROM `users` WHERE `userName`='$commenter'"));
						$commenterPic=$commenterData['propic'];
						$comment=$comment['comment'];
						if ($comment!="") {
						$showCommentTable .= "
							<table class='showCommentTable'>
								<tr>
								<td><img src='propics/$commenterPic'></td>
								<td><span>$commenter</span><br>$comment</td>
								</tr>
							</table>
							";	
						}
					}
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
					// 		<a href=\"profile.php?user=$blogger\"><img src='$location'>
					// 		<span class='blogWriter'>".$blogger."</span></a>
					// 		<div class='blogTitles'>".$title."</div><hr>
					// 		<div class='mainContent'>".$blog['blog']."</div>
					// 		<div class='blogFeedback'>$usefullSpan&nbsp;&nbsp;&nbsp;&nbsp;$wastefullSpan</div><hr>
					// 		<div>$showCommentTable</div>
					// 		<div class='commentPlz'><img src='$locationProfilePic'><input onkeyup='checkEnterPress(event,".$blogid.")' class='commentInput' type='text' placeholder='Enter Your Comment...'><input type='submit' class='buttons commentBtn' value='Comment' onclick='commentPlz(".$blogid.")'></div>
					// 	</div>
					// </div>

					// ";
				}
			}
			elseif (isset($_GET['blogid']) && $_GET['blogid']==0) {
				echo "

					<div class='row'>
						<div class='col-12 blogPosts'>
							<img src='propics/adminbro.png'>
							<span class='blogWriter'>".$admin."</span>
							<div class='mainContent'><pre>This post has been removed by $admin because it was inappropiate for the users of blogFlog.Try posting some useful blogs<br><br>-$admin</pre></div>
						</div>
					</div>

					";
			}
			else
			{
				echo "

					<div class='row'>
						<div class='col-12 blogPosts'>
							<img src='propics/adminbro.png'>
							<span class='blogWriter'>".$admin."</span>
							<div class='mainContent'><pre>It's waste of time trying invlid URLs.</pre></div>
						</div>
					</div>

					";
			}
		?>
	</div>
<div class="deleteConf"></div>
<!-- <div class="col-12 blogEditor"> -->
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
<script type="text/javascript" src="js/util.js"></script>
<script type="text/javascript" src="js/restapis.js"></script>
</html>