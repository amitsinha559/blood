<?php
	include "../inc/common.class.php";
	session_start();
	$code = 0;
	if(isset($_POST['email']) && isset($_POST['password'])) {
		$email = textSafety($_POST['email']);
		$password = passwordSafety($_POST['password']);
		$loginQuery = "SELECT * FROM `login_details` WHERE email='$email' AND password='$password'";
		$loginQueryResult = query($loginQuery);
		while($row = mysql_fetch_array($loginQueryResult)) {
			if($row['isConfirmed'] == "no"){
				$email = $row['email'];
				$name = $row['name'];
				$confirmation_code = $row['confirmation_code'];
				$code = 1001;
				
				$notConfirmedResponse = array(
					'email' => $email,
					'name' => $name,
					'code' => $confirmation_code
				);
				
				//$url="../index.php?email=$email&con=false&no=yes&name=$name&code=$confirmation_code";
			} else {
				if($row['email'] != $email){
					$code = 1002;
					$emailMismatchResponse = array(
						'invalidEmail' => true,
					);
					$_SESSION["isLogin"] = false;
					$_SESSION["email"] = null;
					$_SESSION["name"] = null;
					$_SESSION["id"] = null;
				} else {
					$loggedInResponse = array(
						'isLoggedIn' => true
					);
					$_SESSION["isLogin"] = true;
					$_SESSION["email"] = $row['email'];
					$_SESSION["name"] = $row['name'];
					$_SESSION["id"] = $row['id'];
					// $url="index.php";
					// header("Refresh:0;URL=$url");
					//exit(0);
					$code = 1003;
				}
			}
		}
	}
	$response = array(
		'notConfirmedResponse' => $notConfirmedResponse,
		'loggedInResponse' => $loggedInResponse,
		'emailMismatchResponse' => $emailMismatchResponse,
	);
	header('Content-Type: application/json');
	echo json_encode($response);
?>