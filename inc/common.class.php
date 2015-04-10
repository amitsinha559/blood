<?php

include "database.class.php";
function query($sql){
	$result = Database::getInstance()->query($sql);
	return $result;
}


/*
*	similar to mysql_real_escape_string
*/
function textSafety($value)
{
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	return trim(str_replace($search, $replace, $value));
}

function passwordSafety($value)
{
	$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
	return md5(str_replace($search, $replace, $value));
}

/*	
*	checking whether the browser is mobile browser or not
*/
function isMobile() 
{
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function uploadImage($folder_name)
{
	$file_name = "";
	if ($_FILES["file"]["error"] > 0) 
	{
	  echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 200000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		} 
		else 
		{
			if (file_exists("../".$folder_name."/" . $_FILES["file"]["name"])) 
			{
				echo $_FILES["file"]["name"] . " already exists. ";
				//$file_name = $_FILES["file"]["name"];
			} 
			else 
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"../".$folder_name."/" . $_FILES["file"]["name"]);
				$file_name = $_FILES["file"]["name"];
			}
		}
	}
	return $file_name;
}

function sendMail($to, $to_name, $from, $from_name, $subject, $body){
	echo "1";
	require("phpmailer/class.phpmailer.php");
	echo "2";
	$mail = new PHPMailer();
	$mail->IsSMTP(); // send via SMTP
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = $from; // SMTP username
	$mail->Password = "papiyasinha3__";
	$webmaster_email = $from; //Reply to this email ID
	$email=$to; // Recipients email ID
	$name1=$to_name; // Recipient's name
	$mail->From = $webmaster_email;
	$mail->FromName = $from_name;
	$mail->AddAddress($email,$name1);
	$mail->AddReplyTo($webmaster_email,$from_name);
	$mail->WordWrap = 50; // set word wrap
	//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
	$mail->IsHTML(true); // send as HTML
	$mail->Subject = $subject;
	$mail->Body = $body; //HTML Body
	$mail->AltBody = $body; //Text Body
	if(!$mail->Send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}

function getConfirmationEmailBody($name, $confirmation_code, $sender_name){
	$body = "Hello " . $name . ",<br/><br/>";
	$body .= "You recently created an account in YOUR_APP_NAME. Please click the following link to activate your account <br/>";
	$body .= "<a href='http://localhost/blood/confirm-user.php?k=$confirmation_code'>http://localhost/blood/confirm-user.php?k=$confirmation_code</a><br/><br/>";
	$body .= "(If the link above does not appear clickable or does not open a browser window when you click it, copy it and paste it into your web browser's Location bar.) <br/> <br/>";
	$body .= "Warm Regards, <br/>";
	$body .= $sender_name . "<br/><br/><br/>";
	$body .= "<font size='1px'><b>* </b>This message was sent to you by YOUR_APP_NAME. </font><br/>";
	$body .= "<font size='1px'><b>** </b>You received this message because you have requested to create an account in YOUR_APP_NAME. <br/></font>";
	return $body;
}

function getResetPasswordBody($name, $newPassword, $sender_name){
	$body = "Hello " . $name . ",<br/><br/>";
	$body .= "We received a request to change your password. <br/>";
	$body .= "Your new password is: <b>$newPassword</b><br/><br/><br/>";
	$body .= "Warm Regards, <br/>";
	$body .= $sender_name."<br/>";
	return $body;
}
?>