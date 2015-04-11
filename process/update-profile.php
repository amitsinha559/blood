<?php
	include "../inc/common.class.php";
	
	if(isset($_POST['update_details'])) {
		print_r($_POST);
		echo "<br/><br/>";
		
		$name = textSafety($_POST['name']);
		$gender = textSafety($_POST['gender']);
		$email = textSafety($_POST['email']);
		$blood_group = textSafety($_POST['blood_group']);
		$first_time_donor = textSafety($_POST['first_time_donor']);
		$last_donate_date = textSafety($_POST['last_donate_date']);
		$place_of_donation = textSafety($_POST['place_of_donation']);
		$mobile_number_one = textSafety($_POST['mobile_number_one']);
		$mobile_number_two = textSafety($_POST['mobile_number_two']);
		$zip_code = textSafety($_POST['zip_code']);
		$country = textSafety($_POST['country']);
		$address = textSafety($_POST['address']);
		$comments = textSafety($_POST['comments']);
		$hidden_id = textSafety($_POST['hidden_id']);
		$confirmation_code = md5($email);
		if(!$name || !$gender || !$email || !$blood_group || !$first_time_donor || !$mobile_number_one || !$zip_code || !$country || !$address){
			$url="../update-profile.php?error=100&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comments";
			header("Refresh:0;URL=$url");
			exit(0);
		}
		if($first_time_donor == "No" && ((!$last_donate_date || !$place_of_donation) || $place_of_donation=="Not Selected")){
			$url="../update-profile.php?error=102&msg=lastDatePlace&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comments";
			header("Refresh:0;URL=$url");
			exit(0);
		}
		if($zip_code) {
			//Check whether zip code available or not
		}
		$joining_date = date("Y-m-d");
		// Change it after making login
		$last_login = $today = date("Y-m-d H:i:s");
		$sql = "UPDATE `login_details` SET name = '$name', email = '$email', last_login = '$last_login' WHERE id=$hidden_id";
		$result = query($sql);
		if (!$result) {
			$url="../update-profile.php?error=108&msp=UNKNN&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
			header("Refresh:0;URL=$url");
			exit(0);
		} else {
			//$sql = "SELECT * FROM `login_details` WHERE email='$email'";
			//$loginId = query($sql);
			$last_donate_date_for_db = date("Y-m-d", strtotime($last_donate_date));
			$updateQuery = "UPDATE `donor_details` SET gender = '$gender', blood_group = '$blood_group', first_time_donor = '$first_time_donor', last_donate_date = '$last_donate_date', place_of_donation = '$place_of_donation', mobile_number_one = '$mobile_number_one', mobile_number_two = '$mobile_number_two', zip_code = '$zip_code', country = '$country', address = '$address', comments = '$comments' WHERE login_id = $hidden_id";
			$updateResult = query($updateQuery);
		}

	}
	
?>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		var country = "<?php echo $country; ?>";
		var zipCode = "<?php echo $zip_code; ?>";
		var loginId = "<?php echo $hidden_id; ?>";
		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/" + country + "/" + zipCode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				if(client.statusText === "Not Found" || client.status === 404){
				} else {
					var data = JSON.parse(client.responseText);
					var state = data.places[0].state;
					var allPlaces = "";
					if(data.places.length > 0) {
						for(var i = 0; i < data.places.length ; i++){
							allPlaces = allPlaces + "__" + data.places[i]['place name'];
						}
					}
					var query = "places=" + allPlaces + "&loginId=" + loginId;
					$.ajax({
						type: "POST",
						url: "save-places.php",
						data: query,
						cache: false,
						success: function(html){
							if(html == 1){
								window.location.replace("../index.php");
							}
						}
					});
				}
			}
		};
		client.send();
	});
</script>