<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
	$zip_code = '';
	
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Search Donors</h3><br/>
				<div id="radio">
					<input type="radio" id="radio1" name="radio" checked="checked" onClick="showSearchByArea();"><label for="radio1"><font size="3px">By Area</font></label>
					<input type="radio" id="radio2" name="radio" onClick="showSearchByPinCode();"><label for="radio2"><font size="3px">By Pin Code</font></label>					
				</div>
				<br/>
				<div id="searchByPinCodeId">
					<form method="POST" name="search_donor_form" action="" onsubmit="return validateText()">
						<div class="">Choose Blood Group :</div>
						<div class="">
							<select tabindex="1" style="width: 350px;" id="blood_group" name="blood_group">
								<option value="A+">A+</option>
								<option value="O+">O+</option>
								<option value="B+">B+</option>
								<option value="AB+">AB+</option>
								<option value="A-">A-</option>
								<option value="O-">O-</option>
								<option value="B-">B-</option>
								<option value="AB-">AB-</option>
							</select>
						</div>
						<br/>
						<div class="">Enter Zip Code :</div>
						<div class="">
							<input type="text" tabindex="2" maxlength="60" style="width: 350px;" id="zip_code" name="zip_code" value="600032"/>
						</div>
						<div id="zip_code_error" class="error"></div>
						<br/>
						<div class="">Choose Country: (Optional)</div>
						<div class="">
							<select tabindex="3" id="country" name="country" style="width: 350px;" onmousedown="this.value='';" onchange="onCountryChangeIndex(this.value);">
								<option value="empty">--Select Country--</option>
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
						<br/>
						<div class=""></div>
						<div class="">
							<input type="submit" tabindex="4" class='btn btn-primary' style="width:206px;" name="submit_details" value="Search">
						</div>
					</form>
				</div>
				<div id="searchByAreaId">
					<form method="POST" name="search_donor_by_area_form" action="" onsubmit="return validateSearchByAreaForm()">
						<div class="">Choose Blood Group :</div>
						<div class="">
							<select tabindex="1" style="width: 350px;" id="blood_group_area" name="blood_group_area">
								<option value="A+">A+</option>
								<option value="O+">O+</option>
								<option value="B+">B+</option>
								<option value="AB+">AB+</option>
								<option value="A-">A-</option>
								<option value="O-">O-</option>
								<option value="B-">B-</option>
								<option value="AB-">AB-</option>
							</select>
						</div>
						<div id="blood_group_area_error"></div>
						<br/>
						<div class="">Choose Country :</div>
						<div class="">
							<select tabindex="2" style="width: 350px;" id="country_area" name="country_area" onmousedown="this.value='';" onchange="onCountryChangeForSearch(this.value);">
								<option value="empty">--Select Country--</option>
							<?php
								$getAllCountryNameQuery = "SELECT DISTINCT country FROM `donor_details`";
								$getAllCountryNameResult = query($getAllCountryNameQuery);
								$arr = $country_array;
								while($row = mysql_fetch_array($getAllCountryNameResult)){
									foreach ($arr as $key => $value) {
										if($row['country'] == $key) {
									?>
										<option value="<?php echo $row['country']; ?>"><?php echo $arr[$row['country']]; ?></option>
									<?php			
										}
								
									}
								}
							?>		
							</select>
						</div>
						<div id="country_area_error"></div>
						<br/>
						<div id="placesValueLabel">
							<div class="">Choose Area :</div>
							<div class="">
								<select tabindex="3" style="width: 350px;" id="places_area" name="places_area" onmousedown="this.value='';" onchange="onAreaChange(this.value);">
								</select>
							</div>
						</div>
						<div id="places_area_error"></div>
						<br/>
						<div class=""></div>
						<div id="searchButtonId">
							<input type="submit" tabindex="4" class='btn btn-primary' style="width:206px;" name="search_donors_area" value="Search">
						</div>
					</form>
				</div>
		</article>
		<article>
			<div id="places"></div>
			<div id="list"></div>
			
		</article>
	</div>
</div>
<script src="js/main.js"></script>
<script type="text/javascript">

	function validateSearchByAreaForm() {
		var formName = "search_donor_by_area_form";
		var requiredFields = ["blood_group_area", "country_area", "places_area"];
		var requiredFieldsName = ["Blood Group", "Country", "Area / Locality"];
		var errorIds = ["blood_group_area_error", "country_area_error", "places_area_error"];
		if(!validateFormIndex(formName, requiredFields, requiredFieldsName, errorIds)){
			return false;
		}
		var bloodGroup = document.forms[formName]['blood_group_area'].value;
		var countryCode = document.forms[formName]['country_area'].value;
		var places = document.forms[formName]['places_area'].value;
		
		getDonorListByArea (bloodGroup, countryCode, places);
		
		return false;
		
	}
	
	function getDonorListByArea (bloodGroup, countryCode, places) {
		clearField('places');
		var getLocationQuery = "get=places&area=" + places;
		$.ajax({
			type: "POST",
			url: "process/donor-details.php",
			data: getLocationQuery,
			cache: false,
			success: function(data){
				var placesFromDB = data.split("__");
				var allPlaces = " ";
				$("#places").append("You are searching for <b>"+ bloodGroup + "</b> blood group in places nearby :" + " ");
				for(var i = 1; i < placesFromDB.length ; i++ ){
					allPlaces += " <b> " + placesFromDB[i] + " ,</b>";
				}
				$("#places").append(allPlaces);
			}
		});
		
		var query = "get=list&area=" + places + "&country_code="+countryCode + "&blood_group=" + bloodGroup;
		$.ajax({
			type: "POST",
			url: "process/donor-details.php",
			data: query,
			cache: false,
			success: function(data){
				$("#list").html(data);
			}
		});
	}

	function onAreaChange(value){
		clearField('places');		
		var bloodGroup = document.forms['search_donor_by_area_form']['blood_group_area'].value;
		var countryCode = document.forms['search_donor_by_area_form']['country_area'].value;
		var selectedArea = value;
		getDonorListByArea (bloodGroup, countryCode, selectedArea);
	}

	function showSearchByPinCode(){
		clearField('list');
		clearField('places');
		$("#searchByPinCodeId").show(1000);
		$("#searchByAreaId").hide(1000);
	}

	function showSearchByArea(){
		clearField('list');
		clearField('places');
		$("#searchByPinCodeId").hide(1000);
		$("#searchByAreaId").show(1000);
	}

	$(function(){
		$("#placesValueLabel").hide();
		$("#searchButtonId").hide();
		$("#searchByPinCodeId").hide();
		$( "#radio" ).buttonset();
		clearField('zip_code_error');
		clearField('country_error');
	});
	

	function validateText(){
		clearField('places');
		clearField('list');
		
		clearField('zip_code_error');
		clearField('country_error');
		var formName = "search_donor_form";
		var requiredFields = ["zip_code"];
		var requiredFieldsName = ["Zip Code"];
		var errorIds = ["zip_code_error"];
		if(!validateFormIndex(formName, requiredFields, requiredFieldsName, errorIds)){
			return false;
		}
		
		var bloodGroup = document.forms[formName]['blood_group'].value;
		var zipCode = document.forms[formName]['zip_code'].value;
		var country = document.forms[formName]['country'].value;
		getDonorDetails(bloodGroup, zipCode);
		return false;
	}
</script>

<?php 
	include "footer.php";
?>