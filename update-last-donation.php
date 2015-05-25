<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
	$last_donate_date = ''; $place_of_donation = '';
	
	if(isset($_GET['error'])){
		$error_code = textSafety($_GET['error']);
	}
	if(isset($_GET['last_donate_date'])){
		$last_donate_date = textSafety($_GET['last_donate_date']);
	}
	if(isset($_GET['place_of_donation'])){
		$place_of_donation = textSafety($_GET['place_of_donation']);
	}
	$update_id = 1;
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Please Update Last Donation Details :</h3><br/>
			<form method="POST" name="last_donation_update_form" action="process/update-last-donation.php" onsubmit="return validateLastDonation()">
						<div id="last_donation_date_details">
							<div class="">Last Date of Donate :</div>
							<div class="">
								<input type="date" tabindex="8" maxlength="60" id="last_donate_date" max="<?php echo date("Y-m-d"); ?>" name="last_donate_date" placeholder="yyyy/mm/dd" value="<?php echo $last_donate_date; ?>"/>
							</div>
							<div id="last_donate_error" class="error"></div>
							<br/>
							<div class="">Choose Place of Donation :</div>
							<div class="">
								<select tabindex="9" id="place_of_donation" name="place_of_donation">
									<option value="Blood Camp" <?php if($place_of_donation == "Blood Camp") {echo "selected";}?>>Blood Camp</option>
									<option value="Hospital Blood Bank" <?php if($place_of_donation == "Hospital Blood Bank") {echo "selected";}?>>Hospital Blood Bank</option>
									<option value="Others" <?php if($place_of_donation == "Others") {echo "selected";}?>>Others</option>
								</select>
							</div>
							<div id="place_of_donation_error" class="error"></div>						
							<br/>
						</div>
						<input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $update_id; ?>"/>
						<div class="">
							<input type="submit" tabindex="15" class='btn btn-primary' style="width:206px;" name="update_last_donation_btn" value="Update">
						</div>
				</form>
		</article>
	</div>
</div>

<script src="js/util.js"></script>
<script type="text/javascript">
	$(function() {
		var errorCode = "<?php echo $error_code; ?>";
		clearField('last_donate_error');
		if(errorCode === '100'){
			$("#last_donate_error").html('Please enter a valid date');
		}
	});	
</script>

<?php 
	include "footer.php";
?>