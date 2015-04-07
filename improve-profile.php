<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			<h3>Improve Profile (Optional)</h3><br/>
			<form method="POST" name="donor_form" action="process/create-user.php" onsubmit="return validateText()">
						<div id="globalError" class="error"></div>
						<div class="">Choose Profile Picture :</div>
						<div class="">
							<input type="radio" name="choose_profile_picture" value="from_fb" onclick="getProfilePicFromFB()">From Facebook
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="choose_profile_picture" value="from_pc" onclick="getProfilePicFromPC()">From PC
						</div>
						<div id="name_error" class="error"></div>
						<br/>
						
						<div class="">Update Profile Picture :</div>
						<div class="">
							<input type="text" tabindex="1" maxlength="60" id="name" name="name" value=""/>
						</div>
						<div id="name_error" class="error"></div>
						<br/>
						<div class="">
							<input type="submit" tabindex="15" class='btn btn-primary' style="width:206px;" name="submit_details" value="Submit">
						</div>
						<!-- <img src="//graph.facebook.com/prasenjeet.nath.1/picture?type=large"> -->
				</form>
		</article>
	</div>
</div>

<script type="text/javascript">
	function getProfilePicFromFB(){
		alert('corect');
	}
	
	function getProfilePicFromPC(){
		alert('corect');
	}
	
</script>

<?php 
	include "footer.php";
?>