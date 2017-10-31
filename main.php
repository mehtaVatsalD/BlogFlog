<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location:index.php');
}
$userName=$_SESSION['login'];
include_once('dbconfig.php');
$verified=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `verified` FROM `users` WHERE `userName`='$userName'"));
$verified=$verified['verified'];
if($verified!="verified")
	header("Location:verifyUser.php");

$blockStatus=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `block` FROM `users` WHERE `userName`='$userName'"));
$blockStatus=$blockStatus['block'];
if($blockStatus==1)
{
	$blockMessage="<span style='color:red;'>You are blocked by $admin from posting your blogs and commenting on others' post.<span>";
}

if (isset($_POST['post'])) {
	$postTitle=addslashes($_POST['title']);
	$postContent="<pre>".addslashes($_POST['postContent'])."</pre>";
	$id=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT max(`id`) FROM `blogs`"));
	$id=$id['max(`id`)'];
	$id=$id+1;
	$res=mysqli_query($dbase,"INSERT INTO `blogs` (`id`,`title`,`blog`,`blogger`,`usefull`,`wastefull`) VALUES ('$id','$postTitle','$postContent','$userName','0','0')");

	if($userName!=$admin)
	{
		$notificationText="Person you followed $userName posted new Blog";
		$allfollowers=mysqli_query($dbase,"SELECT `follower` FROM `follow` WHERE `following`='$userName'");
		while($follower=mysqli_fetch_assoc($allfollowers))
		{
			$follower=$follower['follower'];
			mysqli_query($dbase,"INSERT INTO `notifications` (`notify`,`notifier`,`id`,`notification`) VALUES ('$follower','$userName','$id','$notificationText')");
		}
	}
	else
	{
		$notificationText="admin @blogFlog posted new Blog";
		$allfollowers=mysqli_query($dbase,"SELECT `userName` FROM `users` WHERE `userName`<>'$admin'");
		while($follower=mysqli_fetch_assoc($allfollowers))
		{
			$follower=$follower['userName'];
			mysqli_query($dbase,"INSERT INTO `notifications` (`notify`,`notifier`,`id`,`notification`) VALUES ('$follower','$userName','$id','$notificationText')");
		}
	}

	header('location:main.php');

}


// if(isset($_GET['usefull'])){
// 	$id=$_GET['blogid'];
// 	$usefull=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `usefull` FROM `blogs` WHERE `id`='$id'"));
// 	$usefull=$usefull['usefull'];
// 	$usefull=$usefull+1;
// 	mysqli_query($dbase,"UPDATE `blogs` SET `usefull`='$usefull' WHERE `id`='$id'");
// 	header("location:main.php");
// }
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
		<div class="row">
			<div class="col-12 blogEditor">
			<?php
				if($blockStatus==0)
				{
					echo "
						<form action=\"main.php\" method=\"POST\" class=\"postForm\">
							<input type=\"text\" name=\"title\" class=\"postTitle\" placeholder=\"Enter Title for your Blog\">
							<textarea placeholder=\"Write Your Blog Post Here...\" onkeyup=\"handleHeight(this,50)\" maxlength=\"10000\" class=\"postContent\" name='postContent'></textarea>
							<input type=\"submit\" name=\"post\" class=\"buttons\" value=\"Post\">
						</form>
					";
				}
				else
				{
					echo "$blockMessage";
				}
			?>
					
			</div>
		</div>
		<?php
			$flash=md5("flash=true");
			if (isset($_GET[$flash])) {
				echo "<script>alert('Welcome to Take It Easy.You are successfully registerd.Start making question papers and also contribute by uploading valid questions')</script>";
				// header("Location:main.php");
			}
			// $blogFollowers=mysqli_query($dbase,"");
			if($userName==$admin)
			{
				$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE 1 ORDER BY `time` DESC LIMIT 2");
				$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`id`) FROM `blogs` WHERE 1"));
				$minDbId=$minDbId['MIN(`id`)'];
			}
			else
			{
				$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE `blogger` IN (SELECT `following` FROM `follow` WHERE `follower`='$userName') OR `blogger`='$userName' OR `blogger`='$admin' ORDER BY `time` DESC LIMIT 2");
				$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`id`) FROM `blogs` WHERE `blogger` IN (SELECT `following` FROM `follow` WHERE `follower`='$userName') OR `blogger`='$userName' OR `blogger`='$admin'"));
				$minDbId=$minDbId['MIN(`id`)'];
			}
			$flag=0;
			while($blog=mysqli_fetch_assoc($blogsToShow))
			{
				$flag=1;
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
			}

			if(isset($minId) && $minDbId<$minId)
			{
				echo "<div class=\"viewMore\" onclick=\"viewMore($minId,$minDbId,'main','')\">View More</div>";
			}
		// <div class="row">
		// 	<div class="col-12 recommendParent">
		// 		<div class="recommendChild">
		// 			<div class="recommendCards">
		// 				<img src="propics/default.png">
		// 				<p>Name</p>
		// 			</div>
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
</script>
</body>
<script type="text/javascript" src="js/util.js"></script>
<script type="text/javascript" src="js/restapis.js"></script>
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript">
var validate=[
	{
		"class":"postTitle",
		"null": "true"
	},
	{
		"class":"postContent",
		"null":"true"
	},
	"postForm"
];

setValidatorFunction(validate);
</script>
</html>