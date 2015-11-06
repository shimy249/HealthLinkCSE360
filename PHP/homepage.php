<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$notification = $_SESSION['notification'];
if(isset($_SESSION['notification'])){
    unset($_SESSION['notification']);
}
if(isset($_SESSION['diseaseID'])){
    unset($_SESSION['diseaseID']);
}
$schedule_DoctorName;
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
$time = $ts[hours].':'.$ts[minutes].':'.$ts[seconds];
$now = $date.' '.$time;
$refreshApt;
if(isset($_POST['schedule_Doctor']) && isset($_POST['schedule_Doctor'])) $refreshApt = true;
if(refreshApt){
    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "SELECT * FROM Vacations WHERE DoctorID = '".$_POST['schedule_Doctor']."'";
    $result=$conn->query($sql);
    if($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            $aDate = strtotime($_POST['schedule_Date']);
            $bStart = $row['StartDate'];
            $bStart = strtotime($bStart);
            $bEnd = $row['EndDate'];
            $bEnd = strtotime($bEnd);
            if ($aDate >= $bStart && $aDate <= $bEnd){
                $_SESSION['notification'] = "This doctor is on vacation from ".$row['StartDate']. " until ".$row['EndDate'].". Please change the date or schedule with a different doctor.";
                header('Location: homepage.php?');
                return;
            }
        }
    }
    $sql = "SELECT * FROM UserData WHERE _id = '".$_POST['schedule_Doctor']."'" ;
    $result=$conn->query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $schedule_DoctorName = $row['FirstName'].' '.$row['LastName'];
    }
}
function timeslot($aTime){
    $ts =  $GLOBALS['ts'];
    $date = $GLOBALS['date'];
    echo 'hello world';
    echo $ts['hours'].' '.$aTime;
    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "SELECT * FROM Appointments WHERE Date='".$_POST['schedule_Date']."'AND DoctorID = '".$_POST['schedule_Doctor'] ."' AND Hour = '".$aTime."'";
    $result=$conn->query($sql);
    if($result->num_rows == 0){
        if ($date == $_POST['schedule_Date'] && $aTime < $ts['hours']) return;
        echo '<option value="'.$aTime.'">'.$aTime.':00</option>';
    }
}
?>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>IPMS - Home </title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php
?>
<div class="main">
    <h1>IPMS - Home Page</h1>
    <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification ?></text>
    </div>
    <div class="column" style='left:10px; top: 80px;'>

        <!-- Personal Information -->
        <div class="subsection" style="display:block;">
            <center><h2>Personal Information</h2></center>
            <button class="showHideButton" onclick="showHide('PersonalInformation', this)">x</button>
            <div class="sectionContent" id="PersonalInformation" >
                <form action="update_profile.php" method="post">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM UserData WHERE UserName='".$user."'";
                    $result=$conn->query($sql);
                    $userRow = $result->fetch_assoc();
                    ?>
                    <div class = overflow>
                        <div class="sectionLine">
                            First Name:
                            <input type="text" class="sectionLineInput" required name="profile_FirstName" value = "<?php echo $userRow['FirstName'];?>">
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" required name="profile_LastName" value = "<?php echo $userRow['LastName'];?>">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" required name="profile_Email" value = "<?php echo $userRow['Email'];?>">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" required name="profile_Username" value = "<?php echo $userRow['UserName'];?>">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" required name="profile_Password" value = "<?php echo $userRow['Password'];?>" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth:
                            <input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $userRow['DOB'];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput" required>
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" required name="profile_SocialSecurity" value = "<?php echo $userRow['SSN'];?>">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <select class="sectionLineInput" required name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
                        </div>
                        <div class="sectionLine">
                            Street Address:
                            <input type="text" class="sectionLineInput" required name="profile_Address" value = "<?php echo $userRow['Address'];?>">
                        </div>
                        <div class="sectionLine">
                            City:
                            <input type="text" class="sectionLineInput" required name="profile_City" value = "<?php echo $userRow['City'];?>">
                        </div>
                        <div class="sectionLine">
                            State:
                            <select name="profile_State" class="sectionLineInput" required>	<option value="AL">AL</option>	<option value = "" checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
                        </div>
                        <div class="sectionLine">
                            Zip:
                            <input type="text" class="sectionLineInput" required name="profile_Zip" value = "<?php echo $userRow['Zip'];?>">
                        </div>
                        <div class="sectionLine">
                            Phone:
                            <input type="text" class="sectionLineInput" required name="profile_Phone" value = "<?php echo $userRow['Phone'];?>">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" required name="profile_Question1" value = "<?php echo $userRow['q1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" required name="profile_Answer1" value = "<?php echo $userRow['a1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" required name="profile_Question2" value = "<?php echo $userRow['q2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" required name="profile_Answer2" value = "<?php echo $userRow['a2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" required name="profile_Question3" value = "<?php echo $userRow['q3'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" required name="profile_Answer3"  value = "<?php echo $userRow['a3'];?>">
                        </div>

                    </div>
                    <center><input type="submit"  class="submitButton" value="Update Information" action=""></center>
                </form>
            </div>
        </div>

        <!-- Access Patient Case -->
        <div class="subsection" <?php if ($type > 1) echo 'style="display:block;"'; ?>>
            <center><h2>Access Patient Case</h2></center>
            <button class="showHideButton" onclick="showHide('PatientCase', this)">x</button>
            <div class="sectionContent" id="PatientCase">
                <form action="patient_view.php" method = "get">
                    <div class = "sectionLine">
                        Patient:
                        <select name="patient_ID" class = "sectionLineInput" required style = "width: 250px">
                            <?php
                            $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM UserData WHERE Type = '1'";
                            $result=$conn->query($sql);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo '<option value = "'.$row['_id'].'">'.$row['FirstName'].' '.$row['LastName'].' ('.$row['UserName'].')</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <center><input type = "submit" class="submitButton" value = "View Case"></center>

                </form>
            </div>
        </div>

        <!-- Vacations -->
        <div class="subsection" <?php if ($type == 2) echo 'style="display:block;"'; ?>>
            <center><h2>Vacations</h2></center>
            <button class="showHideButton" onclick="showHide('Vacations', this)">x</button>
            <div class="sectionContent" id="Vacations">
                <h3>Book a Vacation</h3>
                <form action="schedule_vacation.php" method="post">
                    <div class = "sectionLine">
                        Start Date: <input type = "date" name="startDate" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput" required>
                    </div>
                    <div class = "sectionLine">
                        End Date: <input type = "date" name="endDate" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput" required>
                    </div>
                    <center><input type = "submit" class="submitButton" value = "Schedule Vacation"></center>
                </form>
                <h3>Manage Vacations</h3>

                <form action="cancel_vacation.php" method = "post">
                    <div class = "overflow">
                        <?php
                        $sql = "SELECT * FROM Vacations WHERE DoctorID='".$userID."'ORDER BY StartDate ASC";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                echo "<div class='appointmentBox'>";
                                echo '<input name = "vacations[]" type="checkbox" value="'.$row['_id'].'" class = "selectBox" style="top:3px;">';
                                echo 'Start Date: <text class="o3">'.$row['StartDate'].'</text> ';
                                echo 'End Date: <text class="o3">'.$row['EndDate'].'</text><br>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <center><input type = "submit" class="submitButton" value = "Cancel Selected Vacations"></center>
                </form>


            </div>
        </div>

        <!-- Add Symptom -->
        <div class="subsection" <?php if($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Add Health Concerns</h2></center>
            <button class="showHideButton" onclick="showHide('AddHealthConcerns', this)">x</button>
            <div class="sectionContent" id="AddHealthConcerns">
                <form action="add_symptom.php" method="post">
                    <input type="hidden" name="patientID" value="<?php echo $userID?>">
                    <input type = "hidden" name="source" value="homepage.php">
                    <div class="sectionLine">
                        Symptom:
                        <select class="sectionLineInput" required name="Symptom" >
                            <option>--Select--</option>
                            <?php
                            $conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM AllSymptoms ORDER BY Name";
                            $result = $conn->query($sql);
                            if ($result->num_rows>0){
                                while ($row = $result->fetch_assoc()){
                                    echo '<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sectionLine">
                        Severity:
                        <select class="sectionLineInput" required  name="Severity" >
                            <option>--Select--</option>
                            <option value="1">1 - Hardly Noticeable</option>
                            <option value="2">2 - Mild</option>
                            <option value="3">3 - Moderate</option>
                            <option value="4">4 - Severe</option>
                            <option value="5">5 - Extreme</option>
                        </select>
                    </div>
                    Additional Notes:
                    <textarea id="AdditionalNotes" style="width: 100%;background-color:#F3F3F3" name="Notes"></textarea>
                    <center><input type="submit" class="submitButton" value="Add Symptom"></center>
                </form>
            </div>
        </div>

        <!-- Current Symptoms -->
        <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Current Health Concerns</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="cancel_symptoms.php" method="post">
                    <input type = "hidden" name="source" value="homepage.php">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Conditions WHERE PatientID='".$userID."'";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                echo "<div class='appointmentBox'>";
                                echo '<input name="symptom[]" type="checkbox" value="'. $row["_id"].'" class = "selectBox">';
                                echo ' Symptom: <text class="o3">'.$row['Symptom'].' ('.$row['Severity'].')</text>';
                                echo ' Date: <text class="p1">'.$row['Date'].'</text>';
                                echo '<br>';
                                echo 'Notes: <text class="p1">'.$row['Notes'].'</text>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <center><input type = "submit" class = "submitButton" value = "Remove Symptoms"></center>
                </form>
            </div>
        </div>



    </div>

    <div class="column" style='left:420px; top: 80px;'>

        <!-- Labwork to Complete -->
        <div class="subsection" <?php if ($type == 3) echo 'style="display:block;"'; ?>>
            <center><h2>Labwork to Complete</h2></center>
            <button class="showHideButton" onclick="showHide('LabworkToComplete', this)">x</button>
            <div class="sectionContent" id="LabworkToComplete">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE Published IS NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <!-- Completed Labwork -->
        <div class="subsection" <?php if ($type == 3) echo 'style="display:block;"'; ?>>
            <center><h2>Completed Labwork</h2></center>
            <button class="showHideButton" onclick="showHide('LabworkToComplete', this)">x</button>
            <div class="sectionContent" id="LabworkToComplete">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE Published IS NOT NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <!-- Your Prescriptions -->
        <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Your Prescriptions</h2></center>
            <button class="showHideButton" onclick="showHide('PatientPrescriptions', this);">x</button>
            <div class="sectionContent" id="PatientPrescriptions">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Prescriptions WHERE PatientID = '".$userID."'";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Date: <text class = "p1">'.$row['Date'].'</text> ';
                            echo 'Medication: <text class = "p1">'.$row['Medication'].'</text> ';
                            echo '<br><a class = "g1" href = "view_prescription.php?prescriptionID='.$row['_id'].'">View/Print Prescription</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no prescriptions.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <!-- Your Labwork -->
        <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Your Labwork</h2></center>
            <button class="showHideButton" onclick="showHide('PatientLabwork', this);">x</button>
            <div class="sectionContent" id="PatientLabwork">
                <h3>Completed Lab Reports</h3>
                <div class = "overflow" style = "max-height:200px;">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE PatientID = '".$userID."'"." AND Report IS NOT NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            if ($type==2) echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
                            else echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">View Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no completed lab reports.<br><br>'
                    ?>
                </div>
                <h3>Pending Lab Reports</h3>
                <div class = "overflow" style = "max-height:100px;">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE PatientID = '".$userID."'"." AND Report IS NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            if ($type==2) echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="subsection" <?php if ($type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Emergency Ward</h2></center>
            <button class="showHideButton" onclick="showHide('Alerts', this)">x</button>
            <div class="sectionContent" id="Alerts">
                <h3>Incoming Patients</h3>
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM EmergencyAppointments WHERE DateTime > '".$now."'ORDER BY Datetime DESC";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $sql = "SELECT * FROM UserData WHERE _id ='".$row['PatientID']."'";
                            $x = $conn->query($sql);
                            $y = $x->fetch_assoc();
                            $name = $y['FirstName']. ' '.$y['LastName'];
                            echo '<div class="appointmentBox">';
                            echo '<text class = "p1">'.$name.'</text> ';
                            echo 'ETA: [<text class = "o3">'.$row['Date'].'</text>]'.'  '.'[<text class = "o3">'.$row['Time'].'</text>]';
                            echo '<br>System Diagnosis: <text class = "b2">'.$row['Diagnosis'].'</text>';
                            echo '</div>';
                        }
                    }
                    echo mysqli_error($conn);
                    ?>
                </div>
                <h3>Past Visits</h3>
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM EmergencyAppointments WHERE Datetime <= '".$now."'ORDER BY Datetime DESC";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $sql = "SELECT * FROM UserData WHERE _id ='".$row['PatientID']."'";
                            $x = $conn->query($sql);
                            $y = $x->fetch_assoc();
                            $name = $y['FirstName']. ' '.$y['LastName'];
                            echo '<div class="appointmentBox">';
                            echo '<text class = "p1">'.$name.'</text> ' ;
                            echo 'ETA: [<text class = "o3">'.$row['Date'].'</text>]'.' '.'[<text class = "o3">'.$row['Time'].'</text>]';
                            echo '<br>System Diagnosis: <text class = "b2">'.$row['Diagnosis'].'</text>';
                            echo '</div>';
                        }
                    }
                    echo mysqli_error($conn);
                    ?>
                </div>
            </div>
        </div>

        <!-- Create Appointment -->
        <div class="subsection" <?php if($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Create Appointment</h2></center>
            <button class="showHideButton" onclick="showHide('CreateAppointment', this)">x</button>
            <div class="sectionContent" id="CreateAppointment">
                <form action="appointment_page.php" method="post">
                    <div class="sectionLine">
                        Primary Symptom:
                        <select class="sectionLineInput" required name="symptom" >
                            <option>--Select--</option>
                            <?php
                            $conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM AllSymptoms ORDER BY Name";
                            $result = $conn->query($sql);
                            if ($result->num_rows>0){
                                while ($row = $result->fetch_assoc()){
                                    echo '<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <center><input type="submit" class="submitButton" value="Request Appointment"></center>
                </form>

            </div>
        </div>

        <!-- Manage Appointments -->
        <div class="subsection"<?php if ($type == 1 || $type == 2) echo 'style="display:block;"'; ?>>
            <center><h2>Manage Appointments</h2></center>
            <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
            <div class="sectionContent" id="ManageAppointments">
                <form action="cancel_appointment.php" method="post">
                    <h3>Past Appointments</h3>
                    <div class = "overflow" style="max-height: 200px;">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = '';
                        if ($type == 1) $sql = "SELECT * FROM Appointments WHERE PatientID='".$userID."'AND  Date <= '".$date."'ORDER BY Date ASC";
                        else $sql = "SELECT * FROM Appointments WHERE DoctorID='".$userID."'AND  Date <= '".$date."'ORDER BY Date ASC";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $sql = "SELECT * FROM UserData WHERE _id='".$row["DoctorID"]."'";
                                $x=$conn->query($sql);
                                if ($x->num_rows > 0) {
                                    $y = $x->fetch_assoc();
                                    $staff = $y["FirstName"] . " " . $y["LastName"];
                                    $sql = "SELECT * FROM UserData WHERE _id='" . $row["PatientID"] . "'";
                                    $x = $conn->query($sql);
                                    if ($x->num_rows > 0) {
                                        $y = $x->fetch_assoc();
                                        $patient = $y["FirstName"] . " " . $y["LastName"];
                                        $date = $row['Date'];
                                        $time = $row['Hour'] . ':00';
                                        $diagnosis = $row['Diagnosis'];
                                        echo "<div class='appointmentBox'>";
                                        echo 'Date: <text class="o3">' . $date . '</text> ';
                                        echo 'Time: <text class="o3">' . $time . '</text><br>';
                                        if ($type == 1) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 2) echo 'Patient: <text class="p1">' . $patient . '</text>';
                                        echo '<br>System Diagnosis: <text class = "b2">'.$row['Diagnosis'].'</text>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                    <h3>Upcoming Appointments</h3>
                    <div class = "overflow" style="max-height: 250px;">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = '';
                        if ($type == 1) $sql = "SELECT * FROM Appointments WHERE PatientID='".$userID."'AND  Date > '".$date."'ORDER BY Date ASC";
                        else $sql = "SELECT * FROM Appointments WHERE DoctorID='".$userID."'AND  Date > '".$date."'ORDER BY Date ASC";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $sql = "SELECT * FROM UserData WHERE _id='".$row["DoctorID"]."'";
                                $x=$conn->query($sql);
                                if ($x->num_rows > 0) {
                                    $y = $x->fetch_assoc();
                                    $staff = $y["FirstName"] . " " . $y["LastName"];
                                    $sql = "SELECT * FROM UserData WHERE _id='" . $row["PatientID"] . "'";
                                    $x = $conn->query($sql);
                                    if ($x->num_rows > 0) {
                                        $y = $x->fetch_assoc();
                                        $patient = $y["FirstName"] . " " . $y["LastName"];
                                        $date = $row['Date'];
                                        $time = $row['Hour'] . ':00';
                                        $diagnosis = $row['Diagnosis'];
                                        echo "<div class='appointmentBox'>";
                                        echo '<input name = "appointments[]" type="checkbox" value="' . $row['_id'] . '" class = "selectBox">';
                                        echo 'Date: <text class="o3">' . $date . '</text> ';
                                        echo 'Time: <text class="o3">' . $time . '</text><br>';
                                        if ($type == 1) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 2) echo 'Patient: <text class="p1">' . $patient . '</text>';
                                        echo '<br>System Diagnosis: <text class = "b2">'.$row['Diagnosis'].'</text>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                    <center><input type="submit"  class="submitButton"  value="Cancel Selected Appointments" action="submit"></center>



                </form>
            </div>
        </div>



    </div>
</div>
</form>
</div>
</body>
</html>
