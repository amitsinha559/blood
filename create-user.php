<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
	$name = ''; $gender = ''; $email = ''; $blood_group = ''; $first_time_donor = ''; $mobile_number_one = ''; $zip_code = ''; $country = ''; $address = ''; $mobile_number_two = ''; $last_donate_date = ''; $place_of_donation = ''; $comment = '';
	if(isset($_GET['name'])){
		$name = textSafety($_GET['name']);
	}
	if(isset($_GET['gender'])){
		$gender = textSafety($_GET['gender']);
	}
	if(isset($_GET['email'])){
		$email = textSafety($_GET['email']);
	}
	if(isset($_GET['blood_group'])){
		$blood_group = textSafety($_GET['blood_group']);
	}
	if(isset($_GET['first_time_donor'])){
		$first_time_donor = textSafety($_GET['first_time_donor']);
	}
	if(isset($_GET['mobile_number_one'])){
		$mobile_number_one = textSafety($_GET['mobile_number_one']);
	}
	if(isset($_GET['zip_code'])){
		$zip_code = textSafety($_GET['zip_code']);
	}
	if(isset($_GET['country'])){
		$country = textSafety($_GET['country']);
	}
	if(isset($_GET['address'])){
		$address = textSafety($_GET['address']);
	}
	if(isset($_GET['mobile_number_two'])){
		$mobile_number_two = textSafety($_GET['mobile_number_two']);
	}
	if(isset($_GET['last_donate_date'])){
		$last_donate_date = textSafety($_GET['last_donate_date']);
	}
	if(isset($_GET['mobile_number_two'])){
		$place_of_donation = textSafety($_GET['place_of_donation']);
	}
	if(isset($_GET['comment'])){
		$comment = textSafety($_GET['comment']);
	}
	$error_code = '';
	if(isset($_GET['error']) && $_GET['error'] == 100) {
		$error_code = 100;
	}
	if(isset($_GET['error']) && $_GET['error'] == 101) {
		$error_code = 101;
	}
	if(isset($_GET['error']) && $_GET['error'] == 102) {
		$error_code = 102;
	}
	if(isset($_GET['error']) && $_GET['error'] == 103) {
		$error_code = 103;
	}
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Please Enter Proper Details</h3><br/>
			<form method="POST" name="donor_form" action="process/create-user.php" onsubmit="return validateText()">
						<div id="globalError" class="error"></div>
						<div class="">Name :</div>
						<div class="">
							<input type="text" tabindex="1" maxlength="60" id="name" name="name" value="<?php echo $name; ?>"/>
						</div>
						<div id="name_error" class="error"></div>
						<br/>
						<div class="">Gender :</div>
						<div class="">
							<select tabindex="2" id="gender" name="gender">
								<option value="Male" <?php if($gender == "Male"){echo 'selected';} ?>>Male</option>
								<option value="Female" <?php if($gender == "Female"){echo 'selected';} ?>>Female</option>
							</select>
						</div>
						<div id="gender_error" class="error"></div>
						<br/>
						<div class="">Email :</div>
						<div class="">
							<input type="text" tabindex="3" maxlength="60" id="email" name="email" value="<?php echo $email; ?>"/>
						</div>
						<div id="email_error" class="error"></div>
						<br/>
						<div class="">Password :</div>
						<div class="">
							<input type="password" tabindex="4" maxlength="60" id="first_password" name="first_password"/>
						</div>
						<div id="pass_one_error" class="error"></div>
						<br/>
						<div class="">Repeat Password :</div>
						<div class="">
							<input type="password" tabindex="5" maxlength="60" id="password" name="repeat_password"/>
						</div>
						<div id="pass_two_error" class="error"></div>
						<br/>
						<div class="">Choose Blood Group :</div>
						<div class="">
							<select tabindex="6" id="blood_group" name="blood_group">
								<option value="A+" <?php if($blood_group == "A"){echo 'selected';} ?>>A+</option>
								<option value="O+" <?php if($blood_group == "O"){echo 'selected';} ?>>O+</option>
								<option value="B+" <?php if($blood_group == "B"){echo 'selected';} ?>>B+</option>
								<option value="AB+" <?php if($blood_group == "AB"){echo 'selected';} ?>>AB+</option>
								<option value="A-" <?php if($blood_group == "A-"){echo 'selected';} ?>>A-</option>
								<option value="O-" <?php if($blood_group == "O-"){echo 'selected';} ?>>O-</option>
								<option value="B-" <?php if($blood_group == "B-"){echo 'selected';} ?>>B-</option>
								<option value="AB-" <?php if($blood_group == "AB-"){echo 'selected';} ?>>AB-</option>
							</select>
						</div>
						<br/>
						<div class="">First Time Donor ? :</div>
						<div class="">
							<select tabindex="7" id="first_time_donor" name="first_time_donor" onmousedown="this.value='';" onchange="onFirstTimeDonorChange(this.value);">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
						<div id="first_time_donor_error" class="error"></div>
						<br/>
						<div id="donor_details">
							<div class="">Last Date of Donate :</div>
							<div class="">
								<input type="text" tabindex="8" maxlength="60" id="last_donate_date" name="last_donate_date" placeholder="mm/dd/yyyy" value="<?php echo $last_donate_date; ?>"/>
							</div>
							<div id="last_donate_error" class="error"></div>
							<br/>
							<div class="">Choose Place of Donation :</div>
							<div class="">
								<select tabindex="9" id="place_of_donation" name="place_of_donation">
									<option value="Not Selected">--Select--</option>
									<option value="Blood Camp">Blood Camp</option>
									<option value="Hospital Blood Bank">Hospital Blood Bank</option>
									<option value="Others">Others</option>
								</select>
							</div>
							<div id="place_of_donation_error" class="error"></div>						
							<br/>
						</div>
						<div class="">Mobile Number 1:</div>
						<div class="">
							<input type="text" tabindex="10" maxlength="60" id="phone_number_one" name="mobile_number_one" value="<?php echo $mobile_number_one; ?>"/>
						</div>
						<div id="mob_one_error" class="error"></div>
						<br/>
						<div class="">Mobile Number 2 <i>(if any)</i>:</div>
						<div class="">
							<input type="text" tabindex="11" maxlength="60" id="mobile_number_two" name="mobile_number_two" value="<?php echo $mobile_number_two; ?>"/>
						</div>
						<div id="mob_two_error" class="error"></div>
						<br/>
						<div class="">Zip Code:</div>
						<div class="">
							<input type="text" tabindex="12" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>"/>
						</div>
						<div id="zip_code_error" class="error"></div>
						<br/>
						<div class="">Choose Country:</div>
						<div class="">
							<select tabindex="13" id="country" name="country" onmousedown="this.value='';" onchange="onCountryChange(this.value);">
							<?php
								$arr = $country_array;
								foreach ($arr as $key => $value) {
							?>
									<option value="<?php echo $key; ?>"><?php echo $arr[$key]; ?></option>
							<?php
								}
							?>
								
							</select>
						</div>
						<div id="country_error" class="error"></div>
						<div id="state_label"></div>
						<div id="state"></div>
						<div id="state_error" class="error"></div>
						<div id="place_label"></div>
						<div id="place"></div>
						<div id="place_error" class="error"></div>
						<br/>
						<div class="">Address:</div>
						<div class="">
							<textarea id="address" tabindex="14" name="address"><?php echo $address; ?></textarea>
						</div>
						<div id="address_error" class="error"></div>
						<br/>
						<div class="">Add Comment:</div>
						<div class="">
							<textarea id="comment" tabindex="15" name="comment"><?php echo $comment; ?></textarea>
						</div>
						<br/>
						<div class=""></div>
						<div class="">
							<input type="submit" tabindex="15" class='btn btn-primary' style="width:206px;" name="submit_details" value="Submit">
						</div>
				</form>
		</article>
	</div>
</div>

<script src="js/util.js"></script>
<script type="text/javascript">

	function onFirstTimeDonorChange(isFirstTime){
		if(isFirstTime === "Yes"){
			$("#donor_details").hide();
		}
		if(isFirstTime === "No") {
			$("#donor_details").show();
		}
	}

	$(function() {
		var errorCode = "<?php echo $error_code; ?>";
		clearField('globalError');
		clearField('pass_one_error');
		clearField('pass_two_error');
		clearField('last_donate_error');
		clearField('place_of_donation_error');
		clearField('email_error');
		if(errorCode === '100'){
			$("#globalError").html('Please enter all the required fields');
		}
		if(errorCode === '101'){
			$("#pass_one_error").html('Password is not matching');
			$("#pass_two_error").html('Password is not matching');
		}
		if(errorCode === '102'){
			$("#last_donate_error").html('Please enter the last date of donation');
			$("#place_of_donation_error").html('Please enter the last donation place');
		}
		if(errorCode === '103'){
			$("#email_error").html('Email is already exist');
		}
		$( "#last_donate_date" ).datepicker();
		$("#donor_details").hide();
	});

	function validateText(){
		var isFirstTimeDonor = document.forms['donor_form']['first_time_donor'].value;
		var requiredFields;
		var requiredFieldsName;
		var errorIds;
		if (isFirstTimeDonor === "Yes") {
			requiredFields = ['name', 'gender', 'email', 'first_password', 'repeat_password', 'mobile_number_one', 'zip_code', 'address'];
			requiredFieldsName = ['Name', 'Gender', 'Email', 'Password', 'Password', 'Mobile Number', 'Zip Code', 'Address'];
			errorIds = ['name_error', 'gender_error', 'email_error','pass_one_error', 'pass_two_error', 'mob_one_error', 'zip_code_error', 'address_error'];
		} else {
			requiredFields = ['name', 'gender', 'email', 'first_password', 'repeat_password', 'last_donate_date', 'place_of_donation', 'mobile_number_one', 'zip_code', 'address'];
			requiredFieldsName = ['Name', 'Gender', 'Email', 'Password', 'Password', 'Last Donate Date', 'Place of Donation', 'Mobile Number', 'Zip Code', 'Address'];
			errorIds = ['name_error', 'gender_error', 'email_error','pass_one_error','pass_two_error','last_donate_error', 'place_of_donation_error', 'mob_one_error', 'zip_code_error', 'address_error'];
		}
		var formName = 'donor_form';
		var params = {
			formName: formName,
			emailFieldName: 'email',
			emailErrorId: 'email_error'
		};
		if(!validateForm(formName, requiredFields, requiredFieldsName, errorIds)){
			return false;
		}
		return true;
	}
	
</script>

<?php 
	include "footer.php";
?>