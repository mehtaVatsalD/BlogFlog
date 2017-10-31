<?php
	ini_set("SMTP","ssl://smtp.gmail.com");
	ini_set("smtp_port","587");
	ini_set("sendmail_from", "mehtavatsald02@gmail.com");
	$to = "mehtavatsald02@gmail.com";
	$from = "";
	$subject = "Your Confirmation link is here";
	$message = "
	<html>
	<head>
	    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
	</head>
	<body>
	<div style='width:70%;display:block;margin:auto;border:1px solid black;background-color:#002233;box-shadow:1px 1px 50px #888888;border-radius:5px'>
	    <h2 style='text-align:center;color:white;font-family: Oswald, sans-serif;'>Blog website User verification</h2>
	    <p style='font-family: Oswald, sans-serif;text-align:center;color:white'>Hello Ch**u,<br><b>Your account activation link is here</b> - http://localhost:8080/Blog/confirmation.php?passkey=1111<p>
	</div>
	</body>
	</html>";
	$headers = "From: vkdhama9@gmail.com\r\n";
	$headers .= "Reply-To: "."mehtavatsald02@gmail.com". "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$mail = mail($to, $subject, $message, $headers);
	if($mail)
	{
		echo "gyo";
	}
	else
	{
		echo "no gyo";
		phpinfo();
	}
?>