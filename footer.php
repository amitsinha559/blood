  <style>  
    label, input { display:block; }
	#dialog-form { font-size: 12px}
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>


				<?php
				$isLoggedIn = false;
				if(isset($_SESSION["email"]) && isset($_SESSION["name"]) && isset($_SESSION["id"]) && $_SESSION["isLogin"]){
					$sessionName = $_SESSION["name"];
					$sessionId = $_SESSION["id"];
					$sessionEmail = $_SESSION["email"];
					$isLoggedIn = $_SESSION["isLogin"];
				}
				?>
				<div id="sidebar">
						<div id="dialog-form" title="Please enter your registered email id">
						 
						  <form>
							<fieldset>
							  <label for="email">Email</label>
							  <input type="text" name="reset_email" id="reset_email" value="amitsinha559@gmail.com" class="text ui-widget-content ui-corner-all">
						 
							  <!-- Allow form submission with keyboard without duplicating the dialog button -->
							  <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
							</fieldset>
						  </form>
						  <p class="validateTips"></p>
						  <p class="Tips">An email will be sent to this email address with your new password</p>
						  <p class="Tips">Not registered yet? <a href="create-user.php">Click here</a> to create new account.</p>						  
						</div>
					
						<!-- Logo -->
							<h1 id="logo"><a href="index.php"><!--<img width="70px" src="images/donate_blood_icon_1.png"><br/>Donate Blood--></a></h1>
					
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current"><a href="index.php">Search Donor</a></li>
									<?php
									if (!$isLoggedIn) {
									?>
										<li class=""><a href="create-user.php">Register & Be a Donor</a></li>
									<?php
									}
									if ($isLoggedIn) {
									?>
										<li><a href="update-last-donation.php">Update Last Donation</a></li>
										<li><a href="update-profile.php">Update Profile</a></li>
										<li><a href="update-password.php">Update Password</a></li>										
									<?php
									}
									?>
									<li><a href="contact-us.php">Contact Us</a></li>
									<?php
									if ($isLoggedIn) {
									?>
										<li><a href="logout.php">Logout</a></li>
									<?php
									}
									?>
									
								</ul>
							</nav>

						<!-- Search 
							<section class="box search">
								<form method="post" action="#">
									<input type="text" class="text" name="search" placeholder="Search" />
								</form>
							</section>
						-->
						
						<?php
						if(!isset($_SESSION["isLogin"]) && !isset($_SESSION["email"]) && !isset($_SESSION["name"])){
							$is_confirmed = true;
							if(isset($_GET['email']) && isset($_GET['con']) && isset($_GET['no']) && ($_GET['con'] == "false") && ($_GET['no'] == "yes") && isset($_GET['name']) && isset($_GET['code'])){
								$is_confirmed = false;
								$email = $_GET['email'];
								$name = $_GET['name'];
								$code = $_GET['code'];
							}
							if(isset($_GET['send']) && isset($_GET['emailto']) && isset($_GET['name']) && isset($_GET['code'])){
								$toName = $_GET['name'];
								$conCode = $_GET['code'];
								$from_name = APP_NAME;
								$body = getConfirmationEmailBody($toName, $conCode, $from_name);
								
								$toEmail = $_GET['emailto'];
								$from = "stackover96@gmail.com";								
								$subject = "Confirmation mail";								
								sendMail($toEmail, $toName, $from, $from_name, $subject, $body);
								
							}
						?>
						<section class="box">
							<form method="POST" name="login_form" action="" onsubmit="return submitLoginForm()">
								<input type="text" tabindex="8" class="text login-box-left" name="login_email" placeholder="Email" />
								<div id="login_email_error"></div>
								<br/>
								<input type="password" tabindex="9" class="password login-box-left" name="login_password" placeholder="Password" />
								<div id="login_password_error"></div>
								<?php
								if(!$is_confirmed){
								?>
								Please confirm your email.
								<a href="index.php?send=true&f=345dd&yu=asd22&emailto=<?php echo $email; ?>&code=<?php echo $code;?>&name=<?php echo $name;?>">Resend confirmation link</a><br/>
								<?php
								} else {
									echo "<br/>";
								}
								?>
								<div id="login_global_error"></div>
								<input type="submit" tabindex="10" style="width:100%; padding: 1.5px 2em 0.5em 2em;" name="login_btn" value="Login">								
							</form>
							<a href="#" id="create-user">Forgot Password?</a>
						</section>
						<?php
						}
						?>
					
						<!-- Text -->
							<section class="box text-style1">
								<div class="inner">
									<p>
										<strong>Change it later:</strong>  Any random quotes / bla bla...
									</p>
								</div>
							</section>
					
						<!-- Recent Posts -->
							<section class="box recent-posts">
								<header>
									<h2>Recent Posts</h2>
								</header>
								<ul>
									<li><a href="#">Quotes Here</a></li>
									<li><a href="#">updates here</a></li>
									<li><a href="#">any links here</a></li>
									<li><a href="#">any info here</a></li>
								</ul>
							</section>
						
						<!-- Copyright -->
							<ul id="copyright">
								<li>&copy; KAAKAI Newspaper.</li>
								<li>Goto: <a href="http://kaakai.in">http://www.kaakai.in</a></li>
							</ul>

					</div>

			</div>

	</body>
</html>
<script src="js/main.js"></script>
<script type="text/javascript">
	function submitLoginForm(){
		clearField('login_email_error');
		clearField('login_password_error');
		var formName = "login_form";
		var requiredFields = ["login_email", "login_password"];
		var requiredFieldsName = ["Email", "Password"];
		var errorIds = ["login_email_error", "login_password_error"];
		var email = document.forms[formName]['login_email'].value;
		var password = document.forms[formName]['login_password'].value;
		if(!validateFormIndex(formName, requiredFields, requiredFieldsName, errorIds)){			
			return false;
		}
		if(!emailValidate(email)){
			$("#login_email_error").html("Please enter a valid email id");
			return false;
		}
		
		doLogin(email, password);
		return false;
	}
	
	
	
</script>