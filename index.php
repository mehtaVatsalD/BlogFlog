<?php
	include('dbconfig.php');
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
	<div class="container">
		<!-- <div class="row">
			<div class="col-12 recommendParent">
				<div class="recommendChild">
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
					<div class="recommendCards">
						<img src="propics/default.png">
						<p>Name</p>
					</div>
				</div>
			</div>
		</div> -->
		<h1>Top Blogs @BlogFlog</h1><hr>
		<?php
			$blogsToShow=mysqli_query($dbase,"SELECT * FROM `blogs` WHERE 1 ORDER BY `usefull` DESC LIMIT 2");
			$minDbId=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT COUNT(`id`) FROM `blogs` WHERE 1"));
			$minDbId=$minDbId['COUNT(`id`)'];//total count
			$minId=2;//offset
			while($blog=mysqli_fetch_assoc($blogsToShow))
			{
				$blogid=$blog['id'];
				$title=$blog['title'];
				$blogger=$blog['blogger'];
				$propic=mysqli_fetch_assoc(mysqli_query($dbase,"SELECT `propic` FROM `users` WHERE `userName`='$blogger'"));
				$location='propics/'.$propic['propic'];
				

				$postToPrint="
				<div class='row'>
					<div class='col-12 blogPosts'>";
				
				$postToPrint.="
						<img src='$location'>
						<span class='blogWriter'>".$blogger."</span>
						<div class='blogTitles'>".$title."</div><hr>
						<div class='mainContent'>".$blog['blog']."</div>
					</div>
				</div>";
				echo "$postToPrint";
			}

			if ($minDbId>$minId) {
				echo "<div class=\"viewMore\" onclick=\"viewMore($minId,$minDbId,'index','')\">View More</div>";	
			}
		?>
	</div>
</body>
<script type="text/javascript" src="js/restapis.js"></script>
</html>