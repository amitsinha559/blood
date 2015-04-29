<?php
	include "../inc/common.class.php";
	if(isset($_POST['loginId'])){
		$id = $_POST['loginId'];
		
		$validatePlacesNearbyQuery = "SELECT * FROM `donor_details` WHERE login_id='$id'";
		$validatePlacesNearbyResult = query($validatePlacesNearbyQuery);
		while($row = mysql_fetch_array($validatePlacesNearbyResult)){
			if ($row['places_nearby'] != ""){
				// ok
			} else {
				$deleteUserFromDonorDetailsQuery = "DELETE FROM `donor_details` WHERE login_id = '$id'";
				$deleteUserFromDonorDetailsResult = query($deleteUserFromDonorDetailsQuery);
				
				$deleteUserFromLoginDetailsQuery = "DELETE FROM `login_details` WHERE id = '$id'";
				$deleteUserFromLoginDetailsResult = query($deleteUserFromLoginDetailsQuery);
				echo 1;
			}
		}
		echo 2;
	} 
?>