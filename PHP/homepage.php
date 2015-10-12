<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>IPMS - Home </title>
	<script type = "text/javascript" src = "main.js">

			
	</script>
	<link rel="stylesheet" type="text/css" href="style.css">
  </style>
</head>
<body>
<div class = "main">
<div id="header">
        <h1>Interactive Patient Management System</h1>
		<div style="position:absolute;right:15px;top:10px;color:white;"> Logged in as <text class = "o4"><b>rdmcclos<?php echo $_GET["user"]; ?></b></text><br></div>
		<div class = "column" style='left:10px; top: 60px;'>
		
			<div class = "subsection">
				<center><h2>Personal Information</h2></center>
				<button class = "showHideButton" onclick = "showHide('PersonalInformation', this)">+</button>
				<div class = "sectionContent" id = "PersonalInformation" style = "display:none;">
					<form action = "EditProfile.php" method = "post">
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
					<center><input type = "submit"  class = "submitButton" value = "Update Information" action = ""></center>
					</form>
				</div>
			</div>
			<div class = "subsection">
				<center><h2>Update Health Concerns</h2></center>
				<button class = "showHideButton" onclick = "showHide('UpdateHealthConcerns', this)">x</button>
				<div class = "sectionContent" id = "UpdateHealthConcerns">
				<form action = "updatehealth.php" method = "post">
					<div class = "sectionLine">
						Symptom: 
						<select class = "sectionLineInput" id = "Symptom" >
							<option>--Select--</option>
							<option>Cough</option>
							<option>Headache</option>
							<option>Sore Throat</option>
							<option>Nausea</option>
							<option>Diarrhoea</option>
							<option>Chest Pain</option>
							<option>Dizziness</option>
							<option>Body Aches</option>
							<option>Chills</option>
							<option>Stiffness</option>
						</select>
					</div>
					<div class = "sectionLine">
						Severity: 
						<select class = "sectionLineInput"  id = "Severity" >
							<option>--Select--</option>
							<option>1 - Hardly Noticeable</option>
							<option>2 - Mild</option>
							<option>3 - Moderate</option>
							<option>4 - Severe</option>
							<option>5 - Extreme</option>
						</select>
					</div>
					Additional Notes:
					<textarea id = "AdditionalNotes" style = "width: 100%;"></textarea>
					<center><input type = "submit" class = "submitButton" value = "Add Symptom" action = "submit"></center>
				</form>
				</div>
			</div>
			
			<div class = "subsection">
				<center><h2>Symptom History</h2></center>
				<button class = "showHideButton" onclick = "showHide('SymptomHistory', this)">x</button>
				<div class = "sectionContent" id = "SymptomHistory">
				<form>
					<div class = "appointmentBox">
						 Symptom: <text class = "p1">Cough</text>
						 <br>
						 Severity: <text class = "p1">3</text>
						 <br>
						 Date: <text class = "p1">10/11/2015</text>
						  <br>
						 Additional Notes: <text class = "p1">Sometimes I fart when I cough.</text>
					</div>
					<div class = "appointmentBox">
						 Symptom: <text class = "p1">Fever</text>
						 <br>
						 Severity: <text class = "p1">4</text>
						 <br>
						 Date: <text class = "p1">10/11/2015</text>
						  <br>
						 Additional Notes: <text class = "p1">My head feels very hot when I put my hand to it</text>
					</div>
				</form>
				</div>
			</div>
			
			
		</div>
		
		<div class = "column" style='left:420px; top: 60px;'>
			<div class = "subsection">
				<center><h2>Schedule Appointment</h2></center>
				<button class = "showHideButton" onclick = "showHide('ScheduleAppointment', this)">x</button>
				<div class = "sectionContent" id = "ScheduleAppointment">
				<form action = "scheduleappointments.php" method = "post">
					<div class = "sectionLine">
							Select a Doctor:
							<select class = "sectionLineInput" id = "schedule_Doctor" >
								<option>--Select--</option>
								<option>Dr. House</option>
								<option>Dr. Dre</option>
								<option>Dr. Jekyll</option>
								<option>Dr. Octopus</option>
								<option>Dr. Seus</option>
							</select>
					</div>
					<div class = "sectionLine">
						Date:
						<select id = "schedule_Month" style = "position: absolute; top: -2px; left: 196px; width: 58px; border: 1px solid #3BA3D0;">
							<option value="0">MM</option>
							<option value="1">01</option>
							<option value="2">02</option>
							<option value="3">p1</option>
							<option value="4">04</option>
							<option value="5">05</option>
							<option value="6">06</option>
							<option value="7">07</option>
							<option value="8">08</option>
							<option value="9">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
						<select id = "schedule_Day" style = "position: absolute; top: -2px; left: 255px; width: 60px; border: 1px solid #3BA3D0;">
							<option value="0">DD</option>
							<option value="1">01</option>
							<option value="2">02</option>
							<option value="3">p1</option>
							<option value="4">04</option>
							<option value="5">05</option>
							<option value="6">06</option>
							<option value="7">07</option>
							<option value="8">08</option>
							<option value="9">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>
						<select id = "schedule_Year" style = "position: absolute; top: -2px; left: 316px; width: 60px; border: 1px solid #3BA3D0;">
							<option value="0">YYYY</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
						</select>
					</div>
					<div class = "sectionLine">
						Time: 
						<select id = "schedule_Time" class = "sectionLineInput">
							<option value="0">--Select--</option>
							<option value="8">8:00 AM</option>
							<option value="9">9:00 AM</option>
							<option value="10">10:00 AM</option>
							<option value="11">11:00 AM</option>
							<option value="12">12:00 PM</option>
							<option value="13">1:00 PM</option>
							<option value="14">2:00 PM</option>
							<option value="15">3:00 PM</option>
							<option value="16">4:00 PM</option>
						</select>
					</div>
					<center><input type = "submit"  class = "submitButton" value = "Request Appointment" action = ""></center>
				</form>
				</div>
			</div>
			<div class = "subsection">
				<center><h2>Manage Appointments</h2></center>
				<button class = "showHideButton" onclick = "showHide('ManageAppointments', this)">x</button>
				<div class = "sectionContent" id = "ManageAppointments">
				<form>
				
					<div class = "appointmentBox">
						<input type="checkbox" value="0" style="position:absolute; left:5px; top:14px;">
						 <span style="display:inline-block; width: 30px;"></span>
						 Doctor: <text class = "p1">Dr. House</text>
						 <span style="display:inline-block; width: 30px;"></span>
						 Patient: <text class = "p1">John Smith</text>
						 <br><span style="display:inline-block; width: 30px;"></span>
						 Date: <text class = "p1">10/30/2015</text>
						  <span style="display:inline-block; width: 30px;"></span>
						 Time: <text class = "p1">4:00 PM</text>
					</div>
					
					<div class = "appointmentBox">
						<input type="checkbox" value="0" style="position:absolute; left:5px; top:14px;">
						 <span style="display:inline-block; width: 30px;"></span>
						 Doctor: <text class = "p1">Dr. Jeckel</text>
						 <span style="display:inline-block; width: 30px;"></span>
						 Patient: <text class = "p1">John Smith</text>
						 <br><span style="display:inline-block; width: 30px;"></span>
						 Date: <text class = "p1">11/30/2015</text>
						  <span style="display:inline-block; width: 30px;"></span>
						 Time: <text class = "p1">9:00 AM</text>
					</div>
					
					<center><input type = "submit"  class = "submitButton"  value = "Cancel Selected Appointments" action = "submit"></center>
					
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
