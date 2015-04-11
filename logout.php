<?php
	session_start();
	if(isset($_SESSION['isLogin']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['id'])) {
		$_SESSION['isLogin'] = null;
		$_SESSION['email'] = null;
		$_SESSION['name'] = null;
		$_SESSION['id'] = null;
	}
	$url="index.php";
	header("Refresh:0;URL=$url");
	exit(0);
?>