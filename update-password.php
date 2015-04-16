<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
	
?>


<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Please Enter Proper Details</h3><br/>
			<form method="POST" name="reset_password_form" action="" onsubmit="return validateChangePasswordForm()">
			<fieldset>
				<div id="globalError" class="error"></div>
				<div class="">Old password :</div>
				<div class="">
					<input type="password" tabindex="1" maxlength="60" id="old_password" name="old_password" value="" title="Please provide your old password."/>
				</div>
				<div id="old_password_error" class="error"></div>
				<br/>
				
				<div class="">New password :</div>
				<div class="">
					<input type="password" tabindex="2" maxlength="60" id="new_password" name="new_password" value="" title="Please provide your new password."/>
				</div>
				<div id="new_password_error" class="error"></div>
				<br/>
				
				<div class="">Repeat New password :</div>
				<div class="">
					<input type="password" tabindex="3" maxlength="60" id="repeat_new_password" name="repeat_new_password" value="" title="Please repeat your new password."/>
				</div>
				<div id="repeat_new_password_error" class="error"></div>
				<br/>
				<div class="">
					<input type="submit" tabindex="4" class='btn btn-primary' style="width:206px;" name="change_password_btn" value="Change Now">
				</div>
				<div id="update_password_loader" style="text-align:center"><img src="images/loader.gif" width="80px"/></div>
			</fieldset>
			</form>			
		</article>
	</div>
</div>

<script src="js/main.js"></script>
<script type="text/javascript">
	$(function(){
		$("#update_password_loader").hide();
	});
	function validateChangePasswordForm(){
		var emailFromSession = "<?php echo $_SESSION['email']; ?>";
		clearField("old_password_error");
		clearField("new_password_error");
		clearField("repeat_new_password_error");
		var form_name = "reset_password_form";
		var requiredFields = ['old_password', 'new_password', 'repeat_new_password'];
		var requiredFieldsName = ['Old password', 'New Password', 'Repeat Password'];
		var errorIds = ['old_password_error', 'new_password_error', 'repeat_new_password_error'];
		
		var oldPassValue = document.forms[form_name]['old_password'].value;
		var newPassword = document.forms[form_name]['new_password'].value;
		var repeatPassword = document.forms[form_name]['repeat_new_password'].value;
		
		$("#update_password_loader").show();
		if(!validateFormIndex(form_name, requiredFields, requiredFieldsName, errorIds)){
			$("#update_password_loader").hide();
			return false;
		}
		
		if(oldPassValue == newPassword) {
			$("#new_password_error").html("Please choose a different password!");
			$("#update_password_loader").hide();
			return false;
		}
		
		validateOldPassword(oldPassValue, emailFromSession, newPassword, repeatPassword);
		
		
		
		return false;
	}
</script>

<?php 
	include "footer.php";
?>