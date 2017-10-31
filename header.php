<?php
	if (isset($_GET['logout'])) {
		session_start();
		session_unset();
		session_destroy();
		header("location:index.php");
	}
?>
<div class="row header">
	<div class="col-3">
		<img src="extra/img/logo.png" class="logoImg" onclick="location.href='login.php'"><span class="logo" onclick="location.href='login.php'">BlogFlog</span>
	</div>
	<div class="col-6" style="position: relative;">
		<?php
		if (isset($_SESSION['login'])) {
			echo "<input type='text' class='searchBox' placeholder='Search Blogger...' onkeyup='searchUsers(this.value)'>
			<div class='searchResult'></div>";
		}
		?>
	</div>
	<div class="col-3">
	<?php
	if (isset($_SESSION['login'])) {
		$location='propics/';
		$userName=$_SESSION['login'];
		$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$userName'"));
		$propic=$propic['propic'];
		$locationProfilePic=$location.$propic;
	
		$notifications=mysqli_query($dbase,"SELECT * FROM `notifications` WHERE `notify`='$userName' ORDER BY `time` DESC");
		$totalRead=0;
		$totalNoti=0;
		$notiTables='';
		$minTimeDb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`time`) FROM `notifications` WHERE `notify`='$userName'"));
		$minTimeDb=$minTimeDb['MIN(`time`)'];
		$minTime='';
		while($notification=mysqli_fetch_assoc($notifications))
		{
			$minTime=$notification['time'];
			$notify=$notification['notify'];
			$notifier=$notification['notifier'];
			$category=$notification['category'];
			$data=$notification['data'];
			if($category=="comment" || $category=="like" || $category=="delete")
			{
				$locationToGo='detailPost.php?blogid='.$data;
			}
			else if($category=="follow")
			{
				$locationToGo='profile.php?user='.$data;
			}
			$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$notifier'"));
			$propic=$propic['propic'];
			$notificationText=$notification['notification'];
			if($notification['readBy']=='0')
			{
				$totalNoti++;
				$notiTables.="
				<table onclick=\"location.href='$locationToGo'\" class='unread'>
					<tr>
						<td><img src='propics/$propic'></td>
						<td>$notificationText</td>
					</tr>
				</table>
				";
			}
			else
			{
				$totalRead++;
				$notiTables.="
				<table onclick=\"location.href='$locationToGo'\">
					<tr>
						<td><img src='propics/$propic'></td>
						<td>$notificationText</td>
					</tr>
				</table>
				";
			}
			if($totalRead>=5)
				break;
		}
		if($minTime!=$minTimeDb)
		{
			$notiTables.="
			<table onclick='viewMoreCmts(\"$minTime\")' class='viewMoreCmts'>
			<tr><td colspan='2'>View More</td></tr>
			</table>
			";
		}

		if($totalNoti>0)
		{
			$bellIcon="<i class=\"fa fa-bell notifySymbol \" style='color: red;' onclick='showNotificationPanel()'>$totalNoti</i>";
		}
		else
		{
			$bellIcon="<i class=\"fa fa-bell notifySymbol \" onclick='showNotificationPanel()'>$totalNoti</i>";
		}
		echo "<img class='headerPic' onclick='dropDownShower()' src='$locationProfilePic'></img><span class='loggedUser' onclick='dropDownShower()'>".$userName." <i class='fa fa-caret-down'></i></span><span id='notiSymbolParent'>$bellIcon<span>";
	}
	else{
		$script=$_SERVER['SCRIPT_NAME'];
		$script=explode('/',$script);
		$script=$script[count($script)-1];
		if($script=="index.php")
		{
			echo "<button type='button' class='buttons2' onclick=\"location.href='signup.php'\">Sign Up</button>";
			echo "<button type='button' class='buttons2' onclick=\"location.href='login.php'\">Login</button>";
		}
	}
	?>
	</div>
</div>
<div class="dropDown">
	<ul>
		<li><form method="GET" action="editProfile.php"><input type="submit" value="Edit Profile" name="editProfile"><input type="hidden" name="userName" value="<?php echo $userName ?>"></form></li>
		<li><form method="GET" action="header.php"><input type="submit" value="Logout" name="logout"></form></li>
	</ul>
</div>
<div class="dropDownBack" onclick="hideDropDown()"></div>

<div class="notifications">
<!-- <span>No Unread Notifications...</span> -->

<?php
	if($notiTables!='')
	{
		echo $notiTables;
	}
	else
	{
		echo "<span>No Notifications Yet...</span>";
	}
?>
</div>
<script type="text/javascript" src="js/util.js"></script>