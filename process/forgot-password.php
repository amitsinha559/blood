<?php
	include "../inc/common.class.php";
	if(isset($_POST['post']) && $_POST['post'] == "pass" && isset($_POST['email'])){
		$email = $_POST['email'];
		$check_email_query = "SELECT email, name from `login_details` WHERE email = '$email'";
		$check_email_result = query($check_email_query);
		while($row = mysql_fetch_array($check_email_result)){
			if($row['email'] == $email) {
				$randomCode = md5(rand());
				$newPassword = substr($randomCode, 1, 7);
				$md5Pass = passwordSafety($newPassword);
				$updatePasswordQuery = "UPDATE `login_details` SET password='$md5Pass' WHERE email='$email'";
				$updatePasswordResult = query($updatePasswordQuery);
				$to_name = $row['name'];
				$sender_name = SENDER_NAME; //warm regards
				$body = getResetPasswordBody($to_name, $newPassword, $sender_name);
				$to = $email;
				$from = SENDER_EMAIL;
				$from_name = APP_NAME;
				$subject = "Reset Password";
				sendMail($to, $to_name, $from, $from_name, $subject, $body);
				echo 1;
			} else {
				echo 2;
			}
		}
		echo 2;
		// Email is not registered
	}
	echo 3;
?>