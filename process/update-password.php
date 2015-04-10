<?php
	include "../inc/common.class.php";
	if(isset($_POST['ajax']) && $_POST['ajax'] == "true" && isset($_POST['email']) && isset($_POST['pass'])){
		$email = textSafety($_POST['email']);
		$password = passwordSafety($_POST['pass']);
		$check_password_query = "SELECT EXISTS(SELECT 1 FROM `login_details` WHERE email='$email' && password = '$password')";
		$check_password_result = query($check_password_query);
		
		while($row = mysql_fetch_array($check_password_result)){
			print_r($row[0]);
			if($row[0] == 0){
				
			}
			if ($row[0] == 1) {
				
			}
			
			// if($row['email'] == $email) {
				// $randomCode = md5($email);
				// $newPassword = substr($randomCode, 1, 7);
				// $to_name = $row['name'];
				// $sender_name = SENDER_NAME; //warm regards
				// $body = getResetPasswordBody($to_name, $newPassword, $sender_name);
				// $to = $email;
				// $from = SENDER_EMAIL;
				// $from_name = APP_NAME;
				// $subject = "Reset Password";
				// sendMail($to, $to_name, $from, $from_name, $subject, $body);
				// echo 1;
			// } else {
				// echo 2;
			// }
		}
		echo 2;
	}
	echo 3;
?>