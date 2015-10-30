<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/27/2015
 * Time: 6:12 PM
 */
session_start();
date_default_timezone_set ('America/Phoenix');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$notification = $_SESSION['notification'];
$patientID = $_GET['patient_ID'];
if(isset($_SESSION['notification'])){
    unset($_SESSION['notification']);
}
$patientName = '';
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn){
    $sql = "SELECT * FROM UserData WHERE _id='".$patientID."'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $patientName = $row['FirstName'].' '.$row['LastName'];
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
    <div id="header">
        <h1>Patient - <?php echo $patientName; ?></h1>
        <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
            Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
            <a href = "homepage.php" style = "color: 00B74A;">Home page</a> | <a href = "logout.php" style = "color: 00B74A;">Log out</a>
        </div>
        <div id="notifications" style="width:100%;text-align:center;">
            <text class="b4"><?php echo $notification ?></text>
        </div>
    </div>

        <div class="column" style='left:10px; top: 80px;'>

            <div class="subsection" style="display:block;">
                <center><h2>Patient Information</h2></center>
                <button class="showHideButton" onclick="showHide('PersonalInformation', this)">x</button>
                <div class="sectionContent" id="PersonalInformation">
                    <form action="update_profile.php" method="post">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM UserData WHERE _id='".$patientID."'";
                        $result=$conn->query($sql);
                        $patientRow = $result->fetch_assoc();

                        ?>
                        <div class="sectionLine">First Name: <text class = "p1"><?php echo $patientRow['FirstName'];?></text></div>
                        <div class="sectionLine">Last Name: <text class = "p1"><?php echo $patientRow['LastName'];?></text></div>
                        <div class="sectionLine">Email: <text class = "p1"><?php echo $patientRow['Email'];?></text></div>
                        <div class="sectionLine">Username: <text class = "p1"><?php echo $patientRow['UserName'];?></text></div>
                        <div class="sectionLine">Date Of Birth (MM/DD/YYYY): <text class = "p1"><?php echo $patientRow['DOB'];?></text></div>
                        <div class="sectionLine">Social Security Number: <text class = "p1"><?php echo $patientRow['SSN'];?></text></div>
                        <div class="sectionLine">Gender: <text class = "p1"><?php echo $patientRow['Gender'];?></text></div>
                        <div class="sectionLine">Physical Address: <text class = "p1"><?php echo $patientRow['Address'];?></text></div>
                    </form>
                </div>
            </div>


            <div class="subsection" <?php if ($type == 3 || $type == 1) echo 'style="display:block;"'; ?>>
                <center><h2>Patient Appointments</h2></center>
                <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
                <div class="sectionContent" id="ManageAppointments">
                    <form>
                        <div class = "overflow">
                            <?php
                            $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = '';
                            $sql = "SELECT * FROM Appointments WHERE PatientID='".$patientID."'ORDER BY StartTime ASC";
                            $result=$conn->query($sql);
                            if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){
                                    $sql = "SELECT * FROM UserData WHERE _id='".$row["StaffID"]."'";
                                    $x=$conn->query($sql);
                                    $y=$x ->fetch_assoc();
                                    $staff=$y["FirstName"]." ".$y["LastName"];
                                    $sql = "SELECT * FROM UserData WHERE _id='".$row["PatientID"]."'";
                                    $x=$conn->query($sql);
                                    $y=$x ->fetch_assoc();
                                    $patient=$y["FirstName"]." ".$y["LastName"];
                                    $datetime = $row["StartTime"];
                                    $date = DateTime::createFromFormat("Y-m-d H:i:s", $datetime);
                                    $d = $date->format('m/d/Y');
                                    $time = $date->format('g:i A');
                                    echo "<div class='appointmentBox'>";
                                    echo '<input type="checkbox" value="0" class = "selectBox">';
                                    echo '<span style="display:inline-block; width: 30px;"></span>';
                                    echo '<div style = "display:inline-block;">';
                                    echo 'Date: <text class="p1">'.$d.'</text> ';
                                    echo 'Time: <text class="p1">'.$time.'</text><br>';
                                    if ($type == 0) echo 'Doctor: <text class="p1">'.$staff.'</text>';
                                    else if ($type == 1) echo 'Patient: <text class="p1">'.$patient.'</text>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            else echo 'This patient does not have any scheduled appointments.'
                            ?>
                        </div>
                        <center><input type="submit"  class="submitButton"  value="Cancel Selected Appointments" action="submit"></center>

                    </form>
                </div>
            </div>
            <div class="subsection" <?php if ($type == 1 || $type == 3 || $type == 4) echo 'style="display:block;"'; ?>>
                <center><h2>Patient Health Concerns</h2></center>
                <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
                <div class="sectionContent" id="CurrentHealthConcerns">
                    <form action="send_alert.php" method="post">
                        <div class = "overflow">
                            <?php
                            $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM MedicalRecords WHERE UserID='".$patientID."' AND Type='Condition'";
                            $result=$conn->query($sql);
                            if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){
                                    $content=$row["Content"];
                                    $times=$row["DateEntered"];
                                    list($currentCond, $currentSever, $currentNotes) = explode("; ", $content);
                                    echo "<div class='appointmentBox'>";
                                    echo '<input name="symptom[]" type="checkbox" value="'. $row["_id"].'" class = "selectBox">';
                                    echo '<span style="display:inline-block; width: 30px;"></span>';
                                    echo '<div style = "display:inline-block;">';
                                    echo 'Date Entered: <text class="p1">'.$times.'</text>';
                                    echo '<br>';
                                    echo 'Symptom: <text class="p1">'.$currentCond.'</text>';
                                    echo '<br>';
                                    echo 'Severity: <text class="p1">'.$currentSever.'</text>';
                                    echo '<br>';
                                    echo 'Additional Information: <text class="p1">'.$currentNotes.'</text>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            echo mysqli_error($conn);
                            ?>
                        </div>
                        <center><input type = "submit" class = "submitButton" value = "Submit Symptoms" action = "submit"></center>
                    </form>
                </div>
            </div>
        </div>

        <div class="column" style='left:420px; top: 80px;'>
            <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
                <center><h2>Prescribe Medication</h2></center>
                <button class="showHideButton" onclick="showHide('PrescribeMedication', this);">x</button>
                <div class="sectionContent" id="PrescribeMedication">
                    <form action="prescribe_medication.php" method="post">
                        <input name = "patientID" type = "hidden" value = "<?php echo $patientID; ?>">
                        <input name = "doctorID" type = "hidden" value = "<?php echo $userID; ?>">
                        <div class = "sectionLine">
                            Medication Name:
                            <input name = "medication" type = "text" class = "sectionLineInput" style = "width: 220px">
                        </div>
                            Presription Instructions:<br>
                            <textarea name = "instructions" type = "text" style = "width: 100%; height: 100px;font-size:inherit;">Strength: &#13;&#10;Form: &#13;&#10;Quantity: &#13;&#10;Dosage: &#13;&#10;Refills: &#13;&#10;Additional Instructions: </textarea>

                        <br>
                        <center><input type = "submit" class = "submitButton" value = "Prescribe Medication"></center>
                    </form>
                </div>
            </div>

            <div class="subsection" style="display:block;">
                <center><h2>Patient Prescriptions</h2></center>
                <button class="showHideButton" onclick="showHide('PatientPrescriptions', this);">x</button>
                <div class="sectionContent" id="PatientPrescriptions">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Prescriptions WHERE PatientID = '".$patientID."'";
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

            <div class="subsection" <?php if ($type == 1) echo 'style="display:block;"'; ?>>
                <center><h2>Prescribe Labwork</h2></center>
                <button class="showHideButton" onclick="showHide('PrescribeLabwork', this);">x</button>
                <div class="sectionContent" id="PrescribeLabwork">
                    <form action="prescribe_labwork.php" method="post">
                        <input name = "patientID" type = "hidden" value = "<?php echo $patientID; ?>">
                        <input name = "doctorID" type = "hidden" value = "<?php echo $userID; ?>">
                        <div class = "sectionLine">
                            Labwork Title:
                            <input name = "title" type = "text" class = "sectionLineInput" style = "width: 270px">
                        </div>
                        <div class = "sectionLine">
                            Description <br>for Lab:
                            <textarea name = "description" type = "text" class = "sectionLineInput" style = "width: 270px"></textarea>
                        </div>
                        <br>
                        <center><input type = "submit" class = "submitButton" value = "Request Labwork"></center>
                    </form>
                </div>
            </div>

            <div class="subsection" style="display:block;">
            <center><h2>Patient Labwork</h2></center>
            <button class="showHideButton" onclick="showHide('PatientLabwork', this);">x</button>
            <div class="sectionContent" id="PatientLabwork">
                <h3>Completed Lab Reports</h3>
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE PatientID = '".$patientID."'"." AND Report IS NOT NULL";
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
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM Labwork WHERE PatientID = '".$patientID."'"." AND Report IS NULL";
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

        </div>


</div>
</body>
</html>
