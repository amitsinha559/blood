<?php
	include "../inc/common.class.php";
	if(isset($_POST['post']) && $_POST['post'] == "pass" && isset($_POST['email'])){
		$email = $_POST['email'];
		$check_email_query = "SELECT email, name from `login_details WHERE email = '$email'";
		$check_email_result = query($check_email_query);
		while($row = mysql_fetch_array($check_email_result)){
			if($row['email'] == $email) {
				$randomCode = md5($email);
				$newPassword = substr($randomCode, 1, 7);				
				
				$body = getResetPasswordBody($name, $newPassword);
				$to = $email;
				$to_name = $row['name'];
				$from = "stackover96@gmail.com";
				$from_name = "YOUR_APP_NAME";
				$subject = "Reset Password";
				
				sendMail($to, $to_name, $from, $from_name, $subject, $body);
				echo 1;
			} else {
				// Email is not registered
			}
		}
		// Email is not registered
	}
?>