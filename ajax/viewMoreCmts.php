<?php
	session_start();
	include_once('../dbconfig.php');
	$userName=$_SESSION['login'];
	$minTime=$_GET['minTime'];
	$notifications=mysqli_query($dbase,"SELECT * FROM `notifications` WHERE `notify`='$userName' AND `time`<'$minTime' ORDER BY `time` DESC LIMIT 5");
	$totalNoti=0;
	$notiTables='';
	$minTimeDb=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT MIN(`time`) FROM `notifications` WHERE `notify`='$userName'"));
	$minTimeDb=$minTimeDb['MIN(`time`)'];
	while($notification=mysqli_fetch_assoc($notifications))
	{
		$minTime=$notification['time'];
		$notify=$notification['notify'];
		$notifier=$notification['notifier'];
		$blogid=$notification['data'];
		$locationToGo='detailPost.php?blogid='.$blogid;
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
			$notiTables.="
			<table onclick=\"location.href='$locationToGo'\">
				<tr>
					<td><img src='propics/$propic'></td>
					<td>$notificationText</td>
				</tr>
			</table>
			";
		}
	}
	if($minTime!=$minTimeDb)
	{
		$notiTables.="
		<table onclick='viewMoreCmts(\"$minTime\")' class='viewMoreCmts'>
		<tr><td colspan='2'>View More</td></tr>
		</table>
		";
	}
	echo $notiTables;
?>