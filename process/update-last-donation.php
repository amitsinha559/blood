<br/><br/><br/>
<div id="update_password_loader" style="text-align:center"><img src="../images/loader.gif" width="80px"/></div>
<br/>
<div style="text-align:center"> <font size="3px">Please wait. Updating Last Date of Donation. </div>
<div style="text-align:center"> It will automatically redirect you to the main page.</div>

<?php

	include "../inc/common.class.php";
	
	if(isset($_POST['update_last_donation_btn'])) {
		if(!$_POST['last_donate_date']){
			$url="../update-last-donation.php?error=100&place_of_donation=" . $_POST['place_of_donation'];
			header("Refresh:0;URL=$url");
			exit(0);
		}
		$last_donate_date = textSafety($_POST['last_donate_date']);
		$place_of_donation = textSafety($_POST['place_of_donation']);
		
		$update_last_date = "UPDATE `donor_details` SET last_donate_date='$last_donate_date', place_of_donation='$place_of_donation' WHERE id=49";
		$update_last_date_result = query($update_last_date);
		$url="../index.php?update=true";
		header("Refresh:0;URL=$url");
		exit(0);
	}
	
?>