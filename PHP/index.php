<?php
session_start();
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
<div id="header">
        <center><h1>Interactive Patient Management System</h1></center>
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
						<input type="text" class="sectionLineInput" name="login_Username" >
					</div>
					<div class="sectionLine">
						Password:
						<input type="password" class="sectionLineInput" name="login_Password" >
					</div>
					<center><input type="submit"  class="submitButton" value="Log In"></center>
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
							<input type="text" class="sectionLineInput" name="profile_FirstName" >
						</div>
						<div class="sectionLine">
							Last Name:
							<input type="text" class="sectionLineInput" name="profile_LastName">
						</div>
						<div class="sectionLine">
							Email Address:
							<input type="text" class="sectionLineInput" name="profile_Email">
						</div>
						<div class="sectionLine">
							Username:
							<input type="text" class="sectionLineInput" name="profile_Username">
						</div>
						<div class="sectionLine">
							Password:
							<input type="text" class="sectionLineInput" name="profile_Password" >
						</div>
						<div class="sectionLine">
							Date Of Birth (MM/DD/YYYY):
							<input type="text" class="sectionLineInput" name="profile_DateOfBirth">
						</div>
						<div class="sectionLine">
							Social Security Number:
							<input type="text" class="sectionLineInput" name="profile_SocialSecurity">
						</div>
						<div class="sectionLine">
							Gender:
							<input type="text" class="sectionLineInput" name="profile_Gender">
						</div>
						<div class="sectionLine">
							Physical Address:
							<input type="text" class="sectionLineInput" name="profile_Address">
						</div>
						<div class="sectionLine">
							Security Question 1:
							<input type="text" class="sectionLineInput" name="profile_Question1" >
						</div>
						<div class="sectionLine">
							Security Answer 1:
							<input type="text" class="sectionLineInput" name="profile_Answer1" >
						</div>
						<div class="sectionLine">
							Security Question 2:
							<input type="text" class="sectionLineInput" name="profile_Question2" >
						</div>
						<div class="sectionLine">
							Security Answer 2:
							<input type="text" class="sectionLineInput" name="profile_Answer2" >
						</div>
						<div class="sectionLine">
							Security Question 3:
							<input type="text" class="sectionLineInput" name="profile_Question3" >
						</div>
						<div class="sectionLine">
							Security Answer 3:
							<input type="text" class="sectionLineInput" name="profile_Answer3" >
						</div>
                        <div class="sectionLine">
                            User Type:
                            <select name = "profile_Type" class = "sectionLineInput">
                                <option value = '0'>Patient</option>
                                <option value = '1'>Doctor</option>
                                <option value = '2'>Lab Technician</option>
                                <option value = '3'>Staff</option>
                                <option value = '4'>Nurse</option>
                            </select>
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
