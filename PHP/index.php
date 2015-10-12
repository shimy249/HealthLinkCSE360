<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Interactive Patient Management System</title>
	<script type = "text/javascript" src = "main.js">

			
	</script>
	<link rel="stylesheet" type="text/css" href="style.css">
  </style>
</head>
<body>
<div class = "main">
<div id="header">
        <center><h1>Interactive Patient Management System</h1></center>
		<div class = "column" style='left:220px; top: 60px;'>
			
			<div class = "subsection">
				<center><h2>Log In</h2></center>
				
				<div class = "sectionContent" id = "SymptomHistory">
				<form action = "login_check.php" method = "post">
					<div class = "sectionLine">
						Username:
						<input type = "text" class = "sectionLineInput" id = "profile_Username" >
					</div>
					<div class = "sectionLine">
						Password:
						<input type = "text" class = "sectionLineInput" id = "profile_Password" >
					</div>
					<center><input type = "submit"  class = "submitButton" value = "Log In" action = ""></center>
				</form>
				</div>
			</div>
		
			<div class = "subsection">
				<center><h2>Registration</h2></center>
				<button class = "showHideButton" onclick = "showHide('PersonalInformation', this)">+</button>
				<div class = "sectionContent" id = "PersonalInformation" style = "display:none;">
					<form action = "Registration.php" method = "post">
						<div class = "sectionLine">
							First Name:
							<input type = "text" class = "sectionLineInput" id = "profile_FirstName" >
						</div>
						<div class = "sectionLine">
							Last Name:
							<input type = "text" class = "sectionLineInput" id = "profile_LastName">
						</div>
						<div class = "sectionLine">
							Email Address:
							<input type = "text" class = "sectionLineInput" id = "profile_Email">
						</div>
						<div class = "sectionLine">
							Username:
							<input type = "text" class = "sectionLineInput" id = "profile_Username">
						</div>
						<div class = "sectionLine">
							Password:
							<input type = "text" class = "sectionLineInput" id = "profile_Password" >
						</div>
						<div class = "sectionLine">
							Date Of Birth (MM/DD/YYYY):
							<input type = "text" class = "sectionLineInput" id = "profile_DateOfBirth">
						</div>
						<div class = "sectionLine">
							Social Security Number:
							<input type = "text" class = "sectionLineInput" id = "profile_SocialSecurity">
						</div>
						<div class = "sectionLine">
							Gender:
							<input type = "text" class = "sectionLineInput" id = "profile_Gender">
						</div>
						<div class = "sectionLine">
							Physical Address:
							<input type = "text" class = "sectionLineInput" id = "profile_Address">
						</div>
						<div class = "sectionLine">
							Security Question 1:
							<input type = "text" class = "sectionLineInput" id = "profile_Question1" >
						</div>
						<div class = "sectionLine">
							Security Answer 1:
							<input type = "text" class = "sectionLineInput" id = "profile_Answer1" >
						</div>
						<div class = "sectionLine">
							Security Question 2:
							<input type = "text" class = "sectionLineInput" id = "profile_Question2" >
						</div>
						<div class = "sectionLine">
							Security Answer 2:
							<input type = "text" class = "sectionLineInput" id = "profile_Answer2" >
						</div>
						<div class = "sectionLine">
							Security Question 3:
							<input type = "text" class = "sectionLineInput" id = "profile_Question3" >
						</div>
						<div class = "sectionLine">
							Security Answer 3:
							<input type = "text" class = "sectionLineInput" id = "profile_Answer3" >
						</div>
						<center><input type = "submit"  class = "submitButton" value = "Register Now"></center>
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
