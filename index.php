<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
	$zip_code = '';
	
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Search Donors</h3>
				<form method="POST" name="search_donor_form" action="" onsubmit="return validateText()">
					<div class="">Enter Zip Code :</div>
					<div class="">
						<input type="text" tabindex="1" maxlength="60" style="width: 350px;" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>"/>
					</div>
					<div id="zip_code_error" class="error"></div>
					<br/>
					<div class="">Choose Country:</div>
					<div class="">
						<select tabindex="2" id="country" name="country" style="width: 350px;" onmousedown="this.value='';" onchange="onCountryChangeIndex(this.value);">
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
						<input type="submit" tabindex="3" class='btn btn-primary' style="width:206px;" name="submit_details" value="Submit">
					</div>
				</form>
		</article>
		<article>
			<div id="places"></div>
		</article>
	</div>
</div>
<script src="js/main.js"></script>
<script type="text/javascript">
	$(function(){
		clearField('zip_code_error');
		clearField('country_error');
	});
	function validateText(){
		var formName = "search_donor_form";
		var requiredFields = ["zip_code"];
		var requiredFieldsName = ["Zip Code"];
		var errorIds = ["zip_code_error"];
		if(!validateForm(formName, requiredFields, requiredFieldsName, errorIds)){
			return false;
		}
		return true;
	}
</script>

<?php 
	include "footer.php";
?>