<?php
	include "../inc/common.class.php";
	
	if(isset($_POST['get']) && isset($_POST['zip_code']) && $_POST['get'] == "list" && isset($_POST['blood_group'])) {
		$zip_code = $_POST['zip_code'];
		$blood_group = $_POST['blood_group'];
		$blood_group = str_replace(' ', '', $blood_group);
		if($blood_group == 'A' || $blood_group == 'B' || $blood_group == 'C'){
			$blood_group = $blood_group."+";
		}
		?>
		<table style="border: 1px solid black;">
			<thead>
				<th>Sl. No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone Number</th>
				<th>More Details</th>
				<th></th>
			</thead>
		<?php
		$getAllDataQuery = "SELECT login_details.id, login_details.name, login_details.email, login_details.joining_date, donor_details.login_id, donor_details.gender, donor_details.blood_group, donor_details.first_time_donor, donor_details.last_donate_date, donor_details.place_of_donation, donor_details.mobile_number_one, donor_details.mobile_number_two, donor_details.zip_code, donor_details.country, donor_details.address, donor_details.places_nearby, donor_details.comments FROM `donor_details` INNER JOIN `login_details` ON donor_details.login_id = login_details.id && donor_details.zip_code='$zip_code' && donor_details.blood_group = '$blood_group'";
		$getAllDataResult = query($getAllDataQuery);
		while($row = mysql_fetch_array($getAllDataResult)){
		?>
			
			<tr>
				<td>Name</td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['mobile_number_one']; ?></td>
				<td>Click Here</td>
				<td>Report</td>
			</tr>
		<?php
		}
		?>		
		</table>
		<?php
	}
?>