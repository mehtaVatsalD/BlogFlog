<?php
	include_once('../dbconfig.php');
	$blogger=$_GET['blogger'];
	$found=false;
	$searchedData='';
	$location='propics/';
	$bloggersSearched=mysqli_query($dbase,"SELECT `userName`,`propic` FROM `users");
	while($bloggerSearched=mysqli_fetch_assoc($bloggersSearched)){
		$bloggerName=$bloggerSearched['userName'];
		if(stripos($bloggerName,$blogger)!==false)
		{
			$found=true;
			$propic=$bloggerSearched['propic'];
			$searchedData.="<li><a href='profile.php?user=$bloggerName'><img src='$location$propic'><span>$bloggerName</span></a><li>";
		}
	}
	if($found)
		echo "<ul>$searchedData</ul>"
?>