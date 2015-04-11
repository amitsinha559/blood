<?php
	include "../inc/common.class.php";
	if(isset($_POST['ajax']) && $_POST['ajax'] == "true" && isset($_POST['email']) && isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['repeatPass'])){
		if($_POST['oldPass'] == "") {
			echo 1;
		}
		if($_POST['newPass'] == "") {
			echo 2;
		}
		if($_POST['repeatPass'] == "") {
			echo 3;
		}
		$email = textSafety($_POST['email']);
		$oldPassword = passwordSafety($_POST['oldPass']);
		$newPass = passwordSafety($_POST['newPass']);
		$repeatPass = passwordSafety($_POST['repeatPass']);
		if($_POST['newPass'] == "" && $_POST['repeatPass'] == "" || ($newPass != $repeatPass)) {
			echo 4;
		} else {
			if($_POST['newPass'] == ""){
				echo 5;
			} else {
				$check_password_query = "SELECT EXISTS(SELECT 1 FROM `login_details` WHERE email='$email' && password = '$oldPassword')";
				$check_password_result = query($check_password_query);
				
				while($row = mysql_fetch_array($check_password_result)){
					if($row[0] == 0){
						echo 6;
					} elseif ($row[0] == 1) {
						$updatePasswordQuery = "UPDATE `login_details` SET password = '$newPass' WHERE email = '$email'";
						$updatePasswordResult = query($updatePasswordQuery);
						echo 7;
					}
				}

			}
		}
		
		
	} else {
		echo 8;
	}
?>