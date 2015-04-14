<style>
  .ui-tooltip {
	*width: 210px;
	font-size: 12px
  }
</style>
<?php
	include "../inc/common.class.php";
	
	if(isset($_POST['get']) && isset($_POST['zip_code']) && $_POST['get'] == "location") {
		$zip_code = textSafety($_POST['zip_code']);
		$getLocaitonQuery = "SELECT DISTINCT places_nearby from `donor_details` WHERE zip_code='$zip_code'";
		$getLocaitonResult = query($getLocaitonQuery);
		while($row = mysql_fetch_array($getLocaitonResult)){
			echo $row['places_nearby'];
		}
	}
	
	if(isset($_POST['get']) && isset($_POST['zip_code']) && $_POST['get'] == "list" && isset($_POST['blood_group'])) {
		$zip_code = textSafety($_POST['zip_code']);
		$blood_group = textSafety($_POST['blood_group']);
		$blood_group = str_replace(' ', '', $blood_group);
		if($blood_group == 'A' || $blood_group == 'B' || $blood_group == 'AB'){
			$blood_group = $blood_group."+";
		}
		?>
		<br/><hr/>
		<table style="border: 1px solid #E3DCDC; align:center">
			<thead>
				<th><b>Sl. No.</b></th>
				<th><b>Name</b></th>
				<th><b>Email</b></th>
				<th><b>Phone Number</b></th>
				<th><b>If Unreachable</b></th>
			</thead>
		<?php
		$getAllDataQuery = "SELECT login_details.id, login_details.name, login_details.email, login_details.joining_date, donor_details.login_id, donor_details.gender, donor_details.blood_group, donor_details.first_time_donor, donor_details.last_donate_date, donor_details.place_of_donation, donor_details.mobile_number_one, donor_details.mobile_number_two, donor_details.zip_code, donor_details.country, donor_details.address, donor_details.places_nearby, donor_details.comments FROM `donor_details` INNER JOIN `login_details` ON donor_details.login_id = login_details.id && donor_details.zip_code='$zip_code' && donor_details.blood_group = '$blood_group' && login_details.isConfirmed = 'yes'";
		$getAllDataResult = query($getAllDataQuery);
		while($row = mysql_fetch_array($getAllDataResult)){
		?>
			
			<tr style="text-align:center">
				<td>Name</td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['mobile_number_one']; ?></td>
				<td><a href="#" onClick="reportDonor(<?php echo $row['id']; ?>)">Report</a></td>
			</tr>
		<?php
		}
		?>		
		</table>
		<?php
	}
?>
<script type="text/javascript">

function reportDonor(id){
	var query = "id=" + id;
	$.ajax({
		type: "POST",
		url: "process/report.php",
		data: query,
		cache: false,
		success: function(html){
			if ( html == 1) {
				alert('User reported successfully. Sorry for the inconvinience. We will take the action soon');
			} 
			if ( html == 2 ) {
				alert('Unknown Error');
			}
		}
	});
}

$(function() {
    var tooltips = $( "[title]" ).tooltip({
      position: {
        my: "left top",
        at: "right+5 top-5"
      }
    });
  });
</script>