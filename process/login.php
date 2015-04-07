<?php
	include "../inc/common.class.php";
	session_start();
	if(isset($_POST['login_btn']) && isset($_POST['login_email']) && isset($_POST['login_password'])) {
		$email = textSafety($_POST['login_email']);
		$password = passwordSafety($_POST['login_password']);
		$loginQuery = "SELECT * FROM `login_details` WHERE email='$email' AND password='$password'";
		$loginQueryResult = query($loginQuery);
		while($row = mysql_fetch_array($loginQueryResult)) {
			if($row['email'] != $email){
				$_SESSION["isLogin"] = false;
				$_SESSION["email"] = null;
				$_SESSION["name"] = null;
			} else {
				$_SESSION["isLogin"] = true;
				$_SESSION["email"] = $row['email'];
				$_SESSION["name"] = $row['name'];
				//$url="update-profile.php";
				//header("Refresh:0;URL=$url");
				//exit(0);
			}
		}
	}
?>