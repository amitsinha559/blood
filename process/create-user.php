<?php
	include "../inc/common.class.php";
	
	if(isset($_POST['submit_details'])) {
		print_r($_POST);
		echo "<br/><br/>";
		
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
		$confirmation_code = md5($email);
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

			
		$body = getConfirmationEmailBody($name, $confirmation_code);
		$to = $email;
		$to_name = $name;
		$from = "stackover96@gmail.com";
		$from_name = "YOUR_APP_NAME";
		$subject = "Confirmation mail";
		
		sendMail($to, $to_name, $from, $from_name, $subject, $body);
		
	}
	
?>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		var country = "<?php echo $country; ?>";
		var zipCode = "<?php echo $zip_code; ?>";
		var loginId = "<?php echo $id; ?>";
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
								alert(html);
								window.location.replace("../confirm-user.php?sent=true");
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