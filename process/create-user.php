<?php

	include "../inc/common.class.php";
	
	if(isset($_POST['submit_details'])) {
		
		
		
		$name = textSafety($_POST['name']);
		$gender = textSafety($_POST['gender']);
		$email = textSafety($_POST['email']);
		$first_password = passwordSafety($_POST['first_password']);
		$repeat_password = passwordSafety($_POST['repeat_password']);			
		$blood_group = textSafety($_POST['blood_group']);
		$first_time_donor = textSafety($_POST['first_time_donor']);
		$last_donate_date = textSafety($_POST['last_donate_date']);
		$place_of_donation = textSafety($_POST['place_of_donation']);
		$mobile_number_one = textSafety($_POST['mobile_number_one']);
		$mobile_number_two = textSafety($_POST['mobile_number_two']);
		$zip_code = textSafety($_POST['zip_code']);
		$country = textSafety($_POST['country']);
		$address = textSafety($_POST['address']);
		$comment = textSafety($_POST['comment']);
		$confirmation_code = md5(rand());
		if(!$name || !$gender || !$email || !$first_password || !$repeat_password || !$blood_group || !$first_time_donor || !$mobile_number_one || !$zip_code || !$country || !$address){
			$url="../create-user.php?error=100&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
			header("Refresh:0;URL=$url");
			exit(0);
		}
		if($first_password != $repeat_password){
			$url="../create-user.php?error=101&msg=passNotMatching&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
			header("Refresh:0;URL=$url");
			exit(0);
		}
	if($first_time_donor == "No" && ((!$last_donate_date || !$place_of_donation) || $place_of_donation=="Not Selected")){
			$url="../create-user.php?error=102&msg=lastDatePlace&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
			header("Refresh:0;URL=$url");
			exit(0);
		}
		if($zip_code) {
			//Check whether zip code available or not
		}
		$joining_date = date("Y-m-d");
		// Change it after making login
		$last_login = $today = date("Y-m-d H:i:s");
		$sql = "INSERT INTO `login_details` (name, email, password, joining_date, last_login, isConfirmed, confirmation_code) VALUES ('$name', '$email', '$first_password', '$joining_date', '$last_login', 'no', '$confirmation_code')";
		$result = query($sql);
		if (!$result) {
			$email_error_message = mysql_error();
			$constructed_email_error = "Duplicate entry '".$email."' for key 'email'";
			if($constructed_email_error == $email_error_message){
				$url="../create-user.php?error=103&msp=DUPEMAIL&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
				header("Refresh:0;URL=$url");
				exit(0);
			}
		} else {
			$sql = "SELECT * FROM `login_details` WHERE email='$email'";
			$loginId = query($sql);
			if(!$loginId) {
				$deleteSql = "DELETE FROM `login_details` WHERE name=$name AND email=$email";
				$deleteQuery = query($deleteSql);
				$url="../create-user.php?name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&zip_code=$zip_code&country=$country&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
				header("Refresh:0;URL=$url");
				exit(0);
			} else {
				while($row = mysql_fetch_array($loginId)) {
					$last_donate_date_for_db = date("Y-m-d", strtotime($last_donate_date));
					$id = $row['id'];
					$insetSql = "INSERT INTO `donor_details` (login_id, gender, blood_group, first_time_donor, last_donate_date, place_of_donation, mobile_number_one, mobile_number_two, zip_code, country, address, comments) VALUES ('$id', '$gender', '$blood_group', '$first_time_donor', '$last_donate_date_for_db', '$place_of_donation', '$mobile_number_one', '$mobile_number_two', '$zip_code', '$country', '$address', '$comment')";
					$insertQuery = query($insetSql);
				}
			}
		}
		
		// $validatePlacesNearbyQuery = "SELECT * FROM `donor_details` WHERE login_id='$id'";
		// $validatePlacesNearbyResult = query($validatePlacesNearbyQuery);
		// while($row = mysql_fetch_array($validatePlacesNearbyResult)){
			// if ($row['places_nearby'] != ""){
				// echo $row['places_nearby'];
				
				// $sender_name = SENDER_NAME; //warm regards
				// $body = getConfirmationEmailBody($name, $confirmation_code, $sender_name);
				// $to = $email;
				// $to_name = $name;
				// $subject = "Confirmation mail";
				
				// $from = SENDER_EMAIL;
				// $from_name = APP_NAME;
				
				// sendMail($to, $to_name, $from, $from_name, $subject, $body);
				
			// } else {
				// $deleteUserFromDonorDetailsQuery = "DELETE FROM `donor_details` WHERE login_id = '$id'";
				// $deleteUserFromDonorDetailsResult = query($deleteUserFromDonorDetailsQuery);
				
				// $deleteUserFromLoginDetailsQuery = "DELETE FROM `login_details` WHERE id = '$id'";
				// $deleteUserFromLoginDetailsResult = query($deleteUserFromLoginDetailsQuery);
				// $url="../create-user.php?error=104&msp=INVPNCD&name=$name&gender=$gender&email=$email&blood_group=$blood_group&first_time_donor=$first_time_donor&last_donate_date=$last_donate_date&place_of_donation=$place_of_donation&mobile_number_two=$mobile_number_two&mobile_number_one=$mobile_number_one&address=$address&comment=$comment";
				// header("Refresh:0;URL=$url");
				// exit(0);
			// }
		// }

		
	}

?>

<div id="waitingMessage" align="center">
<br/><br/><br/>
<div id="regIsUnderProgress"><font size="14px" color="#C3C3C3">Please wait. Registration is under progress.</font></div>
<div id="emailIsUnderProgress"><font size="14px" color="#C3C3C3">Please wait. Sending confirmation email.</font></div>
<br/><br/>
<div id="create_user_loader" style="text-align:center"><img src="../images/loader.gif" width="80px"/></div>
</div>

<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#regIsUnderProgress").show();
		$("#emailIsUnderProgress").hide();
		$("#create_user_loader").show();
		
		var country = "<?php echo $country; ?>";
		var zipCode = "<?php echo $zip_code; ?>";
		var loginId = "<?php echo $id; ?>";		
		var confirmation_code = "<?php echo $confirmation_code; ?>";
		var name = "<?php echo $name; ?>";
		var gender = "<?php echo $gender; ?>";
		var email = "<?php echo $email; ?>";
		var blood_group = "<?php echo $blood_group; ?>";
		var first_time_donor = "<?php echo $first_time_donor; ?>";
		var zip_code = "<?php echo $zip_code; ?>";
		var country = "<?php echo $country; ?>";
		var last_donate_date = "<?php echo $last_donate_date; ?>";
		var place_of_donation = "<?php echo $place_of_donation; ?>";
		var mobile_number_two = "<?php echo $mobile_number_two; ?>";
		var mobile_number_one = "<?php echo $mobile_number_one; ?>";
		var address = "<?php echo $address; ?>";
		var comment = "<?php echo $comment; ?>";

		var client = new XMLHttpRequest();
		client.open("GET", "http://api.zippopotam.us/" + country + "/" + zipCode, true);
		client.onreadystatechange = function() {
			if(client.readyState == 4) {
				if(client.statusText === "Not Found" || client.status === 404){
					var query = "loginId=" + loginId;
					$.ajax({
						type: "POST",
						url: "delete-user-spam.php",
						data: query,
						cache: false,
						success: function(html){
							if (html == 12) {
								$("#regIsUnderProgress").hide();
								$("#emailIsUnderProgress").hide();
								$("#create_user_loader").hide();
								
								window.location.replace("../create-user.php?error=107&msp=INVZPCD&name=" + name + "&gender=" + gender + "&email=" + email + "&blood_group=" + blood_group + "&first_time_donor=" + first_time_donor + "&last_donate_date=" + last_donate_date + "&place_of_donation=" + place_of_donation + "&mobile_number_two=" + mobile_number_two + "&mobile_number_one=" + mobile_number_one + "&address=" + address + "&comment=" + comment);
							} 
							if (html == 2) {
								window.location.replace("../create-user.php?error=105&msp=INVENTR");
							}
						}
					});
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
								$("#regIsUnderProgress").hide();
								$("#emailIsUnderProgress").show();
								$("#create_user_loader").show();
								var query = "loginId=" + loginId + "&name=" + name + "&email=" + email + "&confirmationCode=" + confirmation_code;
								$.ajax({
									type: "POST",
									url: "send-email.php",
									data: query,
									cache: false,
									success: function(res){
										if(res == 1){
											$("#regIsUnderProgress").hide();
											$("#emailIsUnderProgress").hide();
											$("#create_user_loader").hide();
											window.location.replace("../confirm-user.php?sent=true");
										}
									}
								});								
							}
						}
					});
				}
			}
		};
		client.send();		
	});
</script>
<?php
	// $url="../improve-profile.php";
	// header("Refresh:0;URL=$url");
	// exit(0);
?>