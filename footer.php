  <style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
<script>
  $(function() {
    var dialog, form, 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      reset_email = $( "#reset_email" ),
      allFields = $( [] ).add( reset_email ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkRegexp( email, regexp, n ) {
		var email1 = email.val();
		var o = email;
		var atpos=email1.indexOf("@");
		var dotpos=email1.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email1.length){
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		}
		return true;
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
      valid = valid && checkRegexp( reset_email, emailRegex, "eg. amitsinha559@gmail.com" );
 
      if ( valid ) {
		  
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Reset Password": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#create-user" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
  });
  </script>

				<?php
				if(isset($_SESSION["email"]) && isset($_SESSION["name"]) && isset($_SESSION["id"])){
					$sessionName = $_SESSION["name"];
					$sessionId = $_SESSION["id"];
					$sessionEmail = $_SESSION["email"];
				}
				?>
				<div id="sidebar">
					<section>
<div id="dialog-form" title="Please enter your registered email id">
 
  <form>
    <fieldset>
      <label for="email">Email</label>
      <input type="text" name="reset_email" id="reset_email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
  <p class="Tips">An email will be sent to this email address that includes the new password</p>
  <p class="validateTips"></p>
</div>
<button id="create-user">Create user</button>
					</section>
					
						<!-- Logo -->
							<h1 id="logo"><a href="#">STRIPED</a></h1>
					
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current"><a href="#">Latest Post</a></li>
									<li><a href="update-profile.php">Update profile</a></li>
									<li><a href="#">About Me</a></li>
									<li><a href="#">Contact Me</a></li>
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
								$body = getConfirmationEmailBody($toName, $conCode);
								
								$toEmail = $_GET['emailto'];
								$from = "stackover96@gmail.com";
								$from_name = "YOUR_APP_NAME";
								$subject = "Confirmation mail";								
								sendMail($toEmail, $toName, $from, $from_name, $subject, $body);
								
							}
						?>
						<section class="box">
							<form method="POST" name="login_form" action="process/login.php" onsubmit="return submitLoginForm()">
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
								<input type="submit" tabindex="10" style="width:100%; padding: 1.5px 2em 0.5em 2em;" name="login_btn" value="Login">
								<a href="#" onClick="resetPassword()">Forgot password?</a>
							</form>
						</section>
						<?php
						}
						?>
					
						<!-- Text -->
							<section class="box text-style1">
								<div class="inner">
									<p>
										<strong>Striped:</strong> A free and fully responsive HTML5 site
										template designed by <a href="http://n33.co/">AJ</a> for <a href="http://html5up.net/">HTML5 UP</a>
									</p>
								</div>
							</section>
					
						<!-- Recent Posts -->
							<section class="box recent-posts">
								<header>
									<h2>Recent Posts</h2>
								</header>
								<ul>
									<li><a href="#">Lorem ipsum dolor</a></li>
									<li><a href="#">Feugiat nisl aliquam</a></li>
									<li><a href="#">Sed dolore magna</a></li>
									<li><a href="#">Malesuada commodo</a></li>
									<li><a href="#">Ipsum metus nullam</a></li>
								</ul>
							</section>
					
						<!-- Recent Comments -->
							<section class="box recent-comments">
								<header>
									<h2>Recent Comments</h2>
								</header>
								<ul>
									<li>case on <a href="#">Lorem ipsum dolor</a></li>
									<li>molly on <a href="#">Sed dolore magna</a></li>
									<li>case on <a href="#">Sed dolore magna</a></li>
								</ul>
							</section>
					
						<!-- Calendar -->
							<section class="box calendar">
								<div class="inner">
									<table>
										<caption>July 2014</caption>
										<thead>
											<tr>
												<th scope="col" title="Monday">M</th>
												<th scope="col" title="Tuesday">T</th>
												<th scope="col" title="Wednesday">W</th>
												<th scope="col" title="Thursday">T</th>
												<th scope="col" title="Friday">F</th>
												<th scope="col" title="Saturday">S</th>
												<th scope="col" title="Sunday">S</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="4" class="pad"><span>&nbsp;</span></td>
												<td><span>1</span></td>
												<td><span>2</span></td>
												<td><span>3</span></td>
											</tr>
											<tr>
												<td><span>4</span></td>
												<td><span>5</span></td>
												<td><a href="#">6</a></td>
												<td><span>7</span></td>
												<td><span>8</span></td>
												<td><span>9</span></td>
												<td><a href="#">10</a></td>
											</tr>
											<tr>
												<td><span>11</span></td>
												<td><span>12</span></td>
												<td><span>13</span></td>
												<td class="today"><a href="#">14</a></td>
												<td><span>15</span></td>
												<td><span>16</span></td>
												<td><span>17</span></td>
											</tr>
											<tr>
												<td><span>18</span></td>
												<td><span>19</span></td>
												<td><span>20</span></td>
												<td><span>21</span></td>
												<td><span>22</span></td>
												<td><a href="#">23</a></td>
												<td><span>24</span></td>
											</tr>
											<tr>
												<td><a href="#">25</a></td>
												<td><span>26</span></td>
												<td><span>27</span></td>
												<td><span>28</span></td>
												<td class="pad" colspan="3"><span>&nbsp;</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</section>
						
						<!-- Copyright -->
							<ul id="copyright">
								<li>&copy; Untitled.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
							</ul>

					</div>

			</div>

	</body>
</html>
<script src="js/main.js"></script>
<script type="text/javascript">
	function submitLoginForm(){
		var formName = "login_form";
		var requiredFields = ["login_email", "login_password"];
		var requiredFieldsName = ["Email", "Password"];
		var errorIds = ["login_email_error", "login_password_error"];
		if(!validateFormIndex(formName, requiredFields, requiredFieldsName, errorIds)){
			return false;
		}
		return true;
	}
	
	function resetPassword(){
		
	}
	
	
</script>