<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
$notification = $_SESSION['notification'];
$_SESSION['notification'] = '';
?>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Interactive Patient Management System</title>
	<script type="text/javascript" src="main.js">


	</script>
	<link rel="stylesheet" type="text/css" href="style.css">
	</style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<div class="main">
	<center><h1>Interactive Patient Information Management System</h1></center>
	<div id="notifications" style="width:100%;text-align:center;">
		<text class="b4"><?php echo $notification; ?></text>
	</div>
	<div class="column" style='left:220px; top: 80px;'>

		<div class="subsection" style="display:block;">
			<center><h2>Log In</h2></center>

			<div class="sectionContent" id="SymptomHistory">
				<form action="login_check.php" method="post">
					<div class="sectionLine">
						Username:
						<input type="text" class="sectionLineInput" required name="login_Username" >
					</div>
					<div class="sectionLine">
						Password:
						<input type="password" class="sectionLineInput" required name="login_Password" >
					</div>
					<center><input type="submit"  class="submitButton" value="Log In"></center>
				</form>
			</div>
		</div>

		<div class="subsection" style="display:block;">
			<center><h2>Forgot Username/Password</h2></center>
			<button class="showHideButton" onclick="showHide('Forgot', this)">+</button>
			<div class="sectionContent" id="Forgot" style="display: none; max-height:none;">
				<form action="forgot.php" method="post">
					<div class="sectionLine">
						Email Address: <input type="text" class="sectionLineInput" required name="email" >
					</div>
					<center><input type="submit" class = "submitButton" value="Submit"></center>
				</form>
			</div>
		</div>

		<div class="subsection" style="display:block;">
			<center><h2>Registration</h2></center>
			<button class="showHideButton" onclick="showHide('PersonalInformation', this)">+</button>
			<div class="sectionContent" id="PersonalInformation" style="display: none; max-height:none;">
				<form action="Registration.php" method="post">
					<div class="sectionLine">
						First Name:
						<input type="text" class="sectionLineInput" required name="profile_FirstName" >
					</div>
					<div class="sectionLine">
						Last Name:
						<input type="text" class="sectionLineInput" required name="profile_LastName">
					</div>
					<div class="sectionLine">
						Email Address:
						<input type="text" class="sectionLineInput" required name="profile_Email">
					</div>
					<div class="sectionLine">
						Username:
						<input type="text" class="sectionLineInput" required name="profile_Username">
					</div>
					<div class="sectionLine">
						Password:
						<input type="text" class="sectionLineInput" required name="profile_Password" >
					</div>
					<div class="sectionLine">
						Date Of Birth:
						<input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
					</div>
					<div class="sectionLine">
						Social Security Number:
						<input type="text" class="sectionLineInput" required name="profile_SocialSecurity">
					</div>
					<div class="sectionLine">
						Gender:
						<select class="sectionLineInput" required name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
					</div>
					<div class="sectionLine">
						Street Address:
						<input type="text" class="sectionLineInput" required name="profile_Address">
					</div>
					<div class="sectionLine">
						City:
						<input type="text" class="sectionLineInput" required name="profile_City">
					</div>
					<div class="sectionLine">
						State:
						<select name="profile_State" class="sectionLineInput">	<option value="AL">AL</option>	<option value = '' checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
					</div>
					<div class="sectionLine">
						Zip:
						<input type="text" class="sectionLineInput" required name="profile_Zip">
					</div>
					<div class="sectionLine">
						Phone:
						<input type="text" class="sectionLineInput" required name="profile_Phone">
					</div>
					<div class="sectionLine">
						Healthcare Provider:
						<input type="text" class="sectionLineInput" name="profile_Provider">
					</div>
					<div class="sectionLine">
						Policy Number:
						<input type="text" class="sectionLineInput" name="profile_Policy">
					</div>
					<div class="sectionLine">
						Security Question 1:
						<input type="text" class="sectionLineInput" required name="profile_Question1" >
					</div>
					<div class="sectionLine">
						Security Answer 1:
						<input type="text" class="sectionLineInput" required name="profile_Answer1" >
					</div>
					<div class="sectionLine">
						Security Question 2:
						<input type="text" class="sectionLineInput" required name="profile_Question2" >
					</div>
					<div class="sectionLine">
						Security Answer 2:
						<input type="text" class="sectionLineInput" required name="profile_Answer2" >
					</div>
					<div class="sectionLine">
						Security Question 3:
						<input type="text" class="sectionLineInput" required name="profile_Question3" >
					</div>
					<div class="sectionLine">
						Security Answer 3:
						<input type="text" class="sectionLineInput" required name="profile_Answer3" >
					</div>



					<center><input type="submit"  class="submitButton" value="Register Now"></center>
				</form>
			</div>
		</div>









	</div>




</div>
</div>
</form>
</div>
</body>
</html>
