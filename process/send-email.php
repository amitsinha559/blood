<?php
	include "../inc/common.class.php";
	if(isset($_POST['loginId']) && isset($_POST['name']) && isset($_POST['confirmationCode']) && isset($_POST['email'])){
		$id = $_POST['loginId'];
		$name = $_POST['name'];
		$confirmation_code = $_POST['confirmationCode'];
		$email = $_POST['email'];
		
		$sender_name = SENDER_NAME; //warm regards
		$body = getConfirmationEmailBody($name, $confirmation_code, $sender_name);
		$to = $email;
		$to_name = $name;
		$subject = "Confirmation mail";
		
		$from = SENDER_EMAIL;
		$from_name = APP_NAME;
		
		sendMail($to, $to_name, $from, $from_name, $subject, $body);
		echo 1;
	}
?>