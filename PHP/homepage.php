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
$schedule_DoctorName;
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];

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
                            <input type="text" class="sectionLineInput" name="profile_FirstName" value = "<?php echo $userRow['FirstName'];?>">
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" name="profile_LastName" value = "<?php echo $userRow['LastName'];?>">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" name="profile_Email" value = "<?php echo $userRow['Email'];?>">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" name="profile_Username" value = "<?php echo $userRow['UserName'];?>">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" name="profile_Password" value = "<?php echo $userRow['Password'];?>" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth (MM/DD/YYYY):
                            <input type="text" class="sectionLineInput" name="profile_DateOfBirth" value = "<?php echo $userRow['DOB'];?>">
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" name="profile_SocialSecurity" value = "<?php echo $userRow['SSN'];?>">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <input type="text" class="sectionLineInput" name="profile_Gender" value = "<?php echo $userRow['Gender'];?>">
                        </div>
                        <div class="sectionLine">
                            Physical Address:
                            <input type="text" class="sectionLineInput" name="profile_Address" value = "<?php echo $userRow['Address'];?>">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" name="profile_Question1" value = "<?php echo $userRow['q1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" name="profile_Answer1" value = "<?php echo $userRow['a1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" name="profile_Question2" value = "<?php echo $userRow['q2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" name="profile_Answer2" value = "<?php echo $userRow['a2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" name="profile_Question3" value = "<?php echo $userRow['q3'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" name="profile_Answer3"  value = "<?php echo $userRow['a3'];?>">
                        </div>

                    </div>
                    <center><input type="submit"  class="submitButton" value="Update Information" action=""></center>
                </form>
            </div>
        </div>

        <div class="subsection" <?php if ($type > 1) echo 'style="display:block;"'; ?>>
            <center><h2>Access Patient Case</h2></center>
            <button class="showHideButton" onclick="showHide('PatientCase', this)">x</button>
            <div class="sectionContent" id="PatientCase">
                <form action="patient_view.php" method = "get">
                    <div class = "sectionLine">
                        Patient:
                        <select name="patient_ID" class = "sectionLineInput" style = "width: 250px">
                            <?php
                            $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM UserData WHERE Type = '0'";
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

        <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Vacations</h2></center>
            <button class="showHideButton" onclick="showHide('Vacations', this)">x</button>
            <div class="sectionContent" id="Vacations">
                <h3>Book a Vacation</h3>
                <form action="schedule_vacation.php" method="post">
                    <div class = "sectionLine">
                        Start Date: <input type = "date" name="startDate" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                    </div>
                    <div class = "sectionLine">
                        End Date: <input type = "date" name="endDate" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
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
                                echo '<span style="display:inline-block; width: 30px;"></span>';
                                echo '<div style = "display:inline-block;">';
                                echo 'Start Date: <text class="p1">'.$row['StartDate'].'</text> ';
                                echo 'End Date: <text class="p1">'.$row['EndDate'].'</text><br>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <center><input type = "submit" class="submitButton" value = "Cancel Selected Vacations"></center>
                </form>


            </div>
        </div>

        <div class="subsection" <?php if($type == 0) echo 'style="display:block;"'; ?>>
            <center><h2>Add Symptom</h2></center>
            <button class="showHideButton" onclick="showHide('AddHealthConcerns', this)">x</button>
            <div class="sectionContent" id="AddHealthConcerns">
                <form action="add_symptom.php" method="post">
                    <div class="sectionLine">
                        Symptom:
                        <select class="sectionLineInput" name="Symptom" >
                            <option>--Select--</option>
                            <?php
                            $fileName = 'AllSymptoms.txt';
                            $fileContent = file($fileName);
                            foreach($fileContent as $line) {
                                echo '<option value="'.trim($line).'">'.$line.'</option>';
                            }
                            ?>
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
                    <textarea id="AdditionalNotes" style="width: 100%;background-color:#F3F3F3" name="Notes"></textarea>
                    <center><input type="submit" class="submitButton" value="Add Symptom"></center>
                </form>
            </div>
        </div>
        <div class="subsection" <?php if ($type == 0) echo 'style="display:block;"'; ?>>
            <center><h2>Current Symptoms</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="diagnosis.php" method="post">
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
                    <center><input type = "submit" class = "submitButton" value = "Submit and Diagnose"></center>
                </form>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 0) echo 'style="display:block;"'; ?>>
            <center><h2>Current Health Concerns</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="diagnosis.php" method="post">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Diagnosis WHERE PatientID='".$userID."' ORDER BY Date DESC" ;
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                echo '<div class="appointmentBox">';
                                echo '<input name="symptom[]" type="checkbox" value="'. $row["_id"].'" class = "selectBox">';
                                echo 'Date: <text class="p1">'.$row['Date'].'</text>';
                                echo '<br>Symptoms: <text class="o3">'.$row['Symptoms'].'</text>';
                                echo '<br>';
                                echo 'Possible Ailments: <text class="p1">'.$row['Disease'].'</text>';
                                echo '</div>';

                            }
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>




    </div>

    <div class="column" style='left:420px; top: 80px;'>

        <div class="subsection" <?php if ($type == 3) echo 'style="display:block;"'; ?>>
            <center><h2>Labwork to Complete</h2></center>
            <button class="showHideButton" onclick="showHide('LabworkToComplete', this)">x</button>
            <div class="sectionContent" id="LabworkToComplete">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE Report IS NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 3) echo 'style="display:block;"'; ?>>
            <center><h2>Completed Labwork</h2></center>
            <button class="showHideButton" onclick="showHide('LabworkToComplete', this)">x</button>
            <div class="sectionContent" id="LabworkToComplete">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE Report IS NOT NULL";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<div class="appointmentBox">';
                            echo 'Labwork Title: <text class = "p1">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 0) echo 'style="display:block;"'; ?>>
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
                            echo '<br><a style = "color:#00B74A;" href = "view_prescription.php?prescriptionID='.$row['_id'].'">View/Print Prescription</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no prescriptions.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 0) echo 'style="display:block;"'; ?>>
            <center><h2>Patient Labwork</h2></center>
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
                            if ($type==2) echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
                            else echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">View Lab Report</a>';
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
                            if ($type==2) echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';

                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Alerts</h2></center>
            <button class="showHideButton" onclick="showHide('Alerts', this)">x</button>
            <div class="sectionContent" id="Alerts">
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Alerts ORDER BY _id DESC";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $sql = "SELECT * FROM UserData WHERE _id ='".$userID."'";
                            $x = $conn->query($sql);
                            $y = $x->fetch_assoc();
                            $name = $y['FirstName']. ' '.$y['LastName'];
                            echo '<div class="appointmentBox">';
                            echo '<text class = "p1">'.$name.'</text>'.' on '.'<text class = "o3">'.$row['Date'].'</text>'.' at '.'<text class = "o3">'.$row['Time'].'</text>';
                            echo '<br>Health Concerns: <text class = "p1">'.$row['Symptoms'].'</text>';
                            echo '</div>';
                        }
                    }
                    echo mysqli_error($conn);
                    ?>
                </div>
            </div>
        </div>
        <div class="subsection"<?php if ($type == 0) echo 'style="display:block;"'; ?>>
            <center><h2>Schedule Appointment</h2></center>
            <button class="showHideButton" onclick="showHide('ScheduleAppointment', this)">x</button>
            <div class="sectionContent" id="ScheduleAppointment">
                <form action="homepage.php?" method="post">
                    <div class="sectionLine">
                        Select a Doctor:
                        <select class="sectionLineInput" name="schedule_Doctor" >
                            <?php
                            $conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM UserData WHERE Type = 1";
                            $result = $conn->query($sql);
                            if($result->num_rows>0) {
                                while ($row = $result->fetch_assoc())
                                    echo '<option value="' . $row['_id'] . '">' . $row["FirstName"] .' '. $row["LastName"]."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sectionLine">
                        Date:
                        <input type = "date" name="schedule_Date" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                    </div>
                    <center><input type="submit"  class="submitButton" value="View Available Appointments"></center>
                </form>
                <form action="schedule_appointments.php?" method="post" <?php if ($refreshApt) echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                    <input type="hidden" name="schedule_Doctor" value = "<?php echo $_POST['schedule_Doctor'] ?>">
                    <input type="hidden" name="schedule_Date" value = "<?php echo $_POST['schedule_Date'] ?>">
                    <center><h3>Available Appointments</h3></center><br>
                    <div class = "sectionLine">
                        <b><?php echo $schedule_DoctorName. ' on '.$_POST['schedule_Date']?></b><br>
                        <select name = "schedule_Time" class = "sectionLineInput">
                            <?php timeslot(7);timeslot(8);timeslot(9);timeslot(10);timeslot(11);timeslot(12);timeslot(13);timeslot(14);timeslot(15);timeslot(16);?>
                        </select>
                    </div>
                    <center><input type="submit"  class="submitButton" value="Create Appointment"></center>
                </form>
            </div>
        </div>
        <div class="subsection"<?php if ($type == 0 || $type == 1) echo 'style="display:block;"'; ?>>
            <center><h2>Manage Appointments</h2></center>
            <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
            <div class="sectionContent" id="ManageAppointments">
                <form action="cancel_appointment.php" method="post">
                    <h3>Past Appointments</h3>
                    <div class = "overflow" style="max-height: 150px;">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = '';
                        if ($type == 0) $sql = "SELECT * FROM Appointments WHERE PatientID='".$userID."'AND  Date <= '".$date."'ORDER BY Date ASC";
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
                                        echo "<div class='appointmentBox'>";
                                        echo 'Date: <text class="o3">' . $date . '</text> ';
                                        echo 'Time: <text class="o3">' . $time . '</text><br>';
                                        if ($type == 0) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 1) echo 'Patient: <text class="p1">' . $patient . '</text>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                    <h3>Upcoming Appointments</h3>
                    <div class = "overflow" style="max-height: 150px;">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = '';
                        if ($type == 0) $sql = "SELECT * FROM Appointments WHERE PatientID='".$userID."'AND  Date > '".$date."'ORDER BY Date ASC";
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
                                        echo "<div class='appointmentBox'>";
                                        echo '<input name = "appointments[]" type="checkbox" value="' . $row['_id'] . '" class = "selectBox">';
                                        echo 'Date: <text class="o3">' . $date . '</text> ';
                                        echo 'Time: <text class="o3">' . $time . '</text><br>';
                                        if ($type == 0) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 1) echo 'Patient: <text class="p1">' . $patient . '</text>';
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
