<?php
	include_once('../dbconfig.php');
	$blogid=$_POST['blogid'];
	$title=$_POST['title'];
	$post=$_POST['post'];
	$post="<pre>$post</pre>";
	@mysqli_query($dbase,"UPDATE `blogs` SET `title`='$title' WHERE `id`='$blogid'") OR die('dfdf');
	mysqli_query($dbase,"UPDATE `blogs` SET `blog`='$post' WHERE `id`='$blogid'");
	echo "ok";
?>