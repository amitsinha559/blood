<?php
	include "../inc/common.class.php";
	if(isset($_POST['places']) && isset($_POST['loginId'])){
		$places = $_POST['places'];
		$login_id = $_POST['loginId'];
		$insertPlaceQuery = "UPDATE `donor_details` SET places_nearby='$places' WHERE login_id = '$login_id'";
		$resultPlaceQuery = query($insertPlaceQuery);
		echo 1;
	}
?>