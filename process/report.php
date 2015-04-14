<?php
	include "../inc/common.class.php";
	if(isset($_POST['id'])) {
		$id = textSafety($_POST['id']);
		$reportUserQuery = "UPDATE `login_details` SET isReported=true WHERE id='$id'";
		$reportUserResult = query($reportUserQuery);
		echo 1;
	} else {
		echo 2;
	}
?>