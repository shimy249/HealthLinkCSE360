
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>IPMS - Home </title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<div class="main">
    <div id="header">
        <h1>Interactive Patient Management System</h1>
        <div style="position:absolute;right:15px;top:10px;color:white;"> Logged in as <text class="o4"><b><?php echo $_GET["user"]; ?></b></text><br></div>
        <div id="notifications" style="width:100%;text-align:center;">
            <text class="b4"><?php echo $_GET["notification"] ?></text>
        </div>
        <div class="column" style='left:10px; top: 80px;'>

            <div class="subsection">
                <center><h2>Personal Information</h2></center>
                <button class="showHideButton" onclick="showHide('PersonalInformation', this)">+</button>
                <div class="sectionContent" id="PersonalInformation" style="display:none;">
                    <form action="EditProfile.php" method="post">
                        <div class="sectionLine">
                            First Name:
                            <input type="text" class="sectionLineInput" id="profile_FirstName" >
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" id="profile_LastName">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" id="profile_Email">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" id="profile_Username">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" id="profile_Password" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth (MM/DD/YYYY):
                            <input type="text" class="sectionLineInput" id="profile_DateOfBirth">
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" id="profile_SocialSecurity">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <input type="text" class="sectionLineInput" id="profile_Gender">
                        </div>
                        <div class="sectionLine">
                            Physical Address:
                            <input type="text" class="sectionLineInput" id="profile_Address">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" id="profile_Question1" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" id="profile_Answer1" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" id="profile_Question2" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" id="profile_Answer2" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" id="profile_Question3" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" id="profile_Answer3" >
                        </div>
                        <center><input type="submit"  class="submitButton" value="Update Information" action=""></center>
                    </form>
                </div>
            </div>
            <div class="subsection">
                <center><h2>Update Health Concerns</h2></center>
                <button class="showHideButton" onclick="showHide('UpdateHealthConcerns', this)">x</button>
                <div class="sectionContent" id="UpdateHealthConcerns">
                    <form action="updatehealth.php?user=<?php echo $_GET["user"];?>" method="post">
                        <div class="sectionLine">
                            Symptom:
                            <select class="sectionLineInput" name="Symptom" >
                                <option>--Select--</option>
                                <option value="Cough">Cough</option>
                                <option value="Headache">Headache</option>
                                <option value="Sore Throat">Sore Throat</option>
                                <option value="Nausea">Nausea</option>
                                <option value="Diarrhoea">Diarrhoea</option>
                                <option value="Chest Pain">Chest Pain</option>
                                <option value="Dizziness">Dizziness</option>
                                <option value="Body Aches">Body Aches</option>
                                <option value="Chills">Chills</option>
                                <option value="Stiffness">Stiffness</option>
                            </select>
                        </div>
                        <div class="sectionLine">
                            Severity:
                            <select class="sectionLineInput"  name="Severity" >
                                <option>--Select--</option>
                                <option value="1">1 - Hardly Noticeable</option>
                                <option value="2">2 - Mild</option>
                                <option value="3">3 - Moderate</option>
                                <option value="4">4 - Severe</option>
                                <option value="5">5 - Extreme</option>
                            </select>
                        </div>
                        Additional Notes:
                        <textarea id="AdditionalNotes" style="width: 100%;"></textarea>
                        <center><input type="submit" class="submitButton" value="Add Symptom" action="submit"></center>
                    </form>
                </div>
            </div>
            <div class="subsection">
                <center><h2>Current Health Concerns</h2></center>
                <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
                <div class="sectionContent" id="CurrentHealthConcerns">
                    <form action="send_alert.php?user=<?php echo $_GET['user']; ?>" method="post">
                        <?php


                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $user=$_GET["user"];
                        $sql = "SELECT * FROM UserData WHERE UserName='".$user."'";
                        $result=$conn->query($sql);
                        $userID;

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $userID = $row["_id"];
                            }
                        }

                        $sql = "SELECT * FROM MedicalRecords WHERE UserID='".$userID."' AND Type='Condition'";
                        $result=$conn->query($sql);

                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){

                                $content=$row["Content"];
                                $times=$row["DateEntered"];
                                list($currentCond, $currentSever) = explode("; ", $content);
                                echo "<div class='appointmentBox'>";
                                echo '<input name="symptom[]" type="checkbox" value="'. $row["_id"].'" style="position:absolute; left:5px; top:14px;">';

                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Date Entered: <text class="p1">'.$times.'</text>';

                                echo '<br>';
                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Symptom: <text class="p1">'.$currentCond.'</text>';

                                echo '<br>';
                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Severity: <text class="p1">'.$currentSever.'</text>';

                                echo '<br>';
                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Additional Information: <text class="p1">'.$currentCond.'</text>';

                                echo '</div>';

                            }
                        }
                        echo mysqli_error($conn);
                        ?>
                        <center><input type = "submit" class = "submitButton" value = "Submit Symptoms" action = "submit">
                        <input type = "submit" class = "submitButton" value = "Clear Symptoms" action = "submit"></center>
                    </form>
                </div>
            </div>




        </div>

        <div class="column" style='left:420px; top: 80px;'>
            <div class="subsection">
                <center><h2>Alerts</h2></center>
                <button class="showHideButton" onclick="showHide('Alerts', this)">x</button>
                <div class="sectionContent" id="Alerts">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $user=$_GET["user"];
                    $sql = "SELECT * FROM alerts";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo '<br>Patient:'.$row['patient_name'];
                            echo '<br>Summary:'.$row['summary'];
                            echo '</div>';
                        }
                    }
                    echo mysqli_error($conn);
                    ?>

                </div>
            </div>
            <div class="subsection">
                <center><h2>Schedule Appointment</h2></center>
                <button class="showHideButton" onclick="showHide('ScheduleAppointment', this)">x</button>
                <div class="sectionContent" id="ScheduleAppointment">
                    <form action="scheduleappointments.php?user=<?php echo $_GET["user"]; ?>" method="post">
                        <div class="sectionLine">
                            Select a Doctor:
                            <select class="sectionLineInput" name="schedule_Doctor" >
                                <?php
                                $conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                                $sql = "SELECT * FROM UserData WHERE type='Doctor'";
                                $result = $conn->query($sql);
                                if($result->num_rows>0) {
                                    while ($row = $result->fetch_assoc())
                                        echo "<option value=" . $row['_id'] . "'>" . $row["Name"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="sectionLine">
                            Date:
                            <select name="schedule_Month" style="position: absolute; top: -2px; left: 196px; width: 58px; border: 1px solid #3BA3D0;">
                                <option value="00">MM</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select name="schedule_Day" style="position: absolute; top: -2px; left: 255px; width: 60px; border: 1px solid #3BA3D0;">
                                <option value="0">DD</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
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
                            <select name="schedule_Year" style="position: absolute; top: -2px; left: 316px; width: 60px; border: 1px solid #3BA3D0;">
                                <option value="0">YYYY</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                            </select>
                        </div>
                        <div class="sectionLine">
                            Time:
                            <select name="schedule_Time" class="sectionLineInput">
                                <option value="0">--Select--</option>
                                <option value="08">8:00 AM</option>
                                <option value="09">9:00 AM</option>
                                <option value="10">10:00 AM</option>
                                <option value="11">11:00 AM</option>
                                <option value="12">12:00 PM</option>
                                <option value="13">1:00 PM</option>
                                <option value="14">2:00 PM</option>
                                <option value="15">3:00 PM</option>
                                <option value="16">4:00 PM</option>
                            </select>
                        </div>
                        <center><input type="submit"  class="submitButton" value="Request Appointment" action=""></center>
                    </form>
                </div>
            </div>
            <div class="subsection">
                <center><h2>Manage Appointments</h2></center>
                <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
                <div class="sectionContent" id="ManageAppointments">
                    <form>


                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $user=$_GET["user"];
                        $sql = "SELECT * FROM UserData WHERE UserName='".$user."'";
                        $result=$conn->query($sql);
                        $userID;

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $userID = $row["_id"];
                            }
                        }

                        $sql = "SELECT * FROM Appointments WHERE PatientID='".$userID."'";
                        $result=$conn->query($sql);

                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){

                                $sql = "SELECT * FROM UserData WHERE _id='".$row["StaffID"]."'";
                                $x=$conn->query($sql);
                                $y=$x ->fetch_assoc();
                                $staff=$y["Name"];

                                $sql = "SELECT * FROM UserData WHERE _id='".$row["PatientID"]."'";
                                $x=$conn->query($sql);
                                $y=$x ->fetch_assoc();
                                $patient=$y["Name"];

                                $datetime = $row["StartTime"];
                                $date = DateTime::createFromFormat("Y-m-d H:i:s", $datetime);
                                $d = $date->format('m/d/Y');
                                $time = $date->format('g:i A');


                                echo "<div class='appointmentBox'>";
                                echo '<input type="checkbox" value="0" style="position:absolute; left:5px; top:14px;">';

                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Doctor: <text class="p1">'.$staff.'</text>';

                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Patient: <text class="p1">'.$patient.'</text>';

                                echo '<br>';
                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Date: <text class="p1">'.$d.'</text>';


                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo 'Time: <text class="p1">'.$time.'</text>';

                                echo '</div>';

                            }
                        }
                        echo mysqli_error($conn);
                        ?>

                        <center><input type="submit"  class="submitButton"  value="Cancel Selected Appointments" action="submit"></center>

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
