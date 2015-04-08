<?php
	include "../inc/common.class.php";
	if(isset($_POST['places']) && isset($_POST['loginId'])){
		$places = $_POST['places'];
		$login_id = $_POST['loginId'];
	}
	
	if(isse($_POST['updateOnly']) && $_POST['updateOnly'] == "true"){
		
	}
?>