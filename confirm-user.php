<?php 
	include "header.php";
	include "inc/country-code.php";
	include "inc/common.class.php";
?>

<div id="content">
	<div class="inner">
		<article class="box post post-excerpt">
			
			<?php
				if(isset($_GET['k'])){
					$confirmation_code = $_GET['k'];
					$getAccountDetailsQuery = "SELECT name, isConfirmed, email, confirmation_code FROM `login_details` WHERE confirmation_code='$confirmation_code'";
					$getAccountDetailsResult = query($getAccountDetailsQuery);
					while($row = mysql_fetch_array($getAccountDetailsResult)){
						if(($confirmation_code == $row['confirmation_code']) && $row['isConfirmed'] == 'yes'){							
							$name = $row['name'];
						?>
							<h2>Hey <?php echo $name; ?>, </h2><br/>
							<h3>Your email is already confirmed.<br/><br/></h3>
							<a href="index.php">Return to Home</a>
						<?php
						} else if(($confirmation_code == $row['confirmation_code']) && $row['isConfirmed'] == 'no'){
							$activateAccountQuery = "UPDATE `login_details` SET isConfirmed='yes' WHERE confirmation_code='$confirmation_code'";
							$activateAccountResult = query($activateAccountQuery);
							$name = $row['name'];
						?>
						<br/><br/>
						<h2>Hello <?php echo $name; ?>, </h2><br/>
						<h3>You have successfully verified. Use <b><?php echo $row['email']; ?></b> for login purpose. <br/><br/></h3>
						<a href="index.php">Return to Home</a>
						<?php
						} else {
						?>
							<h2>Oops!! <?php echo $name; ?>, </h2><br/>
							<h3>Confirmation code is not valid<br/><br/></h3>
						<?php
						}
					}
				} elseif(isset($_GET['sent']) && $_GET['sent'] == "true"){
				?>
					<br/>
					<h2>Confirmation email sent!</h2><br/>
					<h3>
					A confirmation email has been sent to your email address. Follow the instruction wihthin the email to activate your account.<br/>
					If you do not receive the confirmation email, make sure you are the registered user for this portal. You should also check your spam email folder for the confirmation mail.</h3>
				<?php
				}
			
			?>
			
			
		</article>
	</div>
</div>

<?php 
	include "footer.php";
?>