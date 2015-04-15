<?php
	include "../inc/common.class.php";
	if(isset($_POST['get']) && isset($_POST['country_code']) && $_POST['get'] == "area") {
		$country_code = textSafety($_POST['country_code']);
		$getAreaListQuery = "SELECT DISTINCT places_nearby FROM `donor_details` WHERE country = '$country_code'";
		$getAreaListResult = query($getAreaListQuery);
		$allArea = "";
		while($row = mysql_fetch_array($getAreaListResult)){
			$places_nearby = $row['places_nearby'];
			//$allArea .= $row['places_nearby'];
			$placesPieces = explode("__", $places_nearby);
			for($i = 0; $i < count($placesPieces) ; $i++) {
				if($placesPieces[$i] != null) {
					$allArea .= '<option value="'. $placesPieces[$i] .'">'. $placesPieces[$i] .'</option>';
				}
			}			
		}
		$response = array(
			'success' => TRUE,
			'options' => $allArea
		);
	} else {
		$response = array(
			'success' => FALSE
		);
	}
	header('Content-Type: application/json');
	echo json_encode($response);
?>