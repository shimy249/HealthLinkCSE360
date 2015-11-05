<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/27/2015
 * Time: 6:12 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
echo $type;
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
            <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
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
                    First Name: <text class = "p1"><?php echo $patientRow['FirstName'];?></text><br>
                    Last Name: <text class = "p1"><?php echo $patientRow['LastName'];?></text><br>
                    Email: <text class = "p1"><?php echo $patientRow['Email'];?></text><br>
                    Username: <text class = "p1"><?php echo $patientRow['UserName'];?></text><br>
                    Date Of Birth: <text class = "p1"><?php echo $patientRow['DOB'];?></text><br>
                    Gender: <text class = "p1"><?php echo $patientRow['Gender'];?></text><br>
                    Address: <text class = "p1"><?php echo $patientRow['Address'] .', '.$patientRow['City'].', ' .$patientRow['State'].' '.$patient['Zip'] ;;?></text><br>
                    Phone Number: <text class = "p1"><?php echo $patientRow['Phone'];?></text><br>
                </form>
            </div>
        </div>

        <!-- Patient Appointments -->
        <div class="subsection"<?php if ($type == 1 || $type == 2 || $type == 4 || $type == 5 || $type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Patient Appointments</h2></center>
            <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
            <div class="sectionContent" id="ManageAppointments">
                <form action="cancel_appointment.php" method="post">
                    <h3>Past Appointments</h3>
                    <div class = "overflow" style="max-height: 150px;">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = '';
                        $sql = "SELECT * FROM Appointments WHERE PatientID='".$patientID."'AND  Date <= '".$date."'ORDER BY Date ASC";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $sql = "SELECT * FROM UserData WHERE _id='".$row["DoctorID"]."'";
                                $x=$conn->query($sql);
                                if ($x->num_rows > 0) {
                                    $y = $x->fetch_assoc();
                                    $patient = $y["FirstName"] . " " . $y["LastName"];
                                    $date = $row['Date'];
                                    $time = $row['Hour'] . ':00';
                                    $diagnosis = $row['Diagnosis'];
                                    echo "<div class='appointmentBox'>";
                                    echo '<input name = "appointments[]" type="checkbox" value="' . $row['_id'] . '" class = "selectBox">';
                                    echo 'Doctor: <text class="p1">' . $staff . '</text> ';
                                    echo 'on <text class="o3">' . $date . '</text> at <text class="o3">' . $time . '</text><br>';
                                    echo 'System Diagnosis: <text class="b2">' . $diagnosis . '</text>';
                                    echo '</div>';
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
                        $sql = "SELECT * FROM Appointments WHERE PatientID='".$patientID."'AND  Date > '".$date."'ORDER BY Date ASC";
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
                                        echo 'Doctor: <text class="p1">' . $staff . '</text> ';
                                        echo 'on <text class="o3">' . $date . '</text> at <text class="o3">' . $time . '</text><br>';
                                        echo 'System Diagnosis: <text class="b2">' . $diagnosis . '</text>';
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

        <!-- Update Health Concerns -->
        <div class="subsection" <?php if($type == 2 || $type == 5 || $type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Add Health Concerns</h2></center>
            <button class="showHideButton" onclick="showHide('AddHealthConcerns', this)">x</button>
            <div class="sectionContent" id="AddHealthConcerns">
                <form action="add_symptom.php" method="post">
                    <input type="hidden" name="patientID" value="<?php echo $patientID?>">
                    <input type = "hidden" name="source" value="patient_view.php?patient_ID=<?php echo $patientID?>">
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
                    <textarea id="AdditionalNotes" class = "appointmentBox" style="width: 100%; padding: 5px;" name="Notes"></textarea>
                    <center><input type="submit" class="submitButton" value="Add Symptom"></center>
                </form>
            </div>
        </div>

        <!-- Current Health Concerns -->
        <div class="subsection" <?php if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Current Health Concerns</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="cancel_symptoms.php" method="post">
                    <input type = "hidden" name="source" value="patient_view.php?patient_ID=<?php echo $patientID?>">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Conditions WHERE PatientID='".$patientID."'";
                        $result=$conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                echo "<div class='appointmentBox'>";
                                echo '<input name="symptom[]" type="checkbox" value="'. $row["_id"].'" class = "selectBox">';
                                echo ' Symptom: <text class="p1">'.$row['Symptom'].' ('.$row['Severity'].')</text>';
                                echo ' Date: <text class="o3">'.$row['Date'].'</text>';
                                echo '<br>';
                                if ($row['Notes'])echo 'Notes: <text class="b2">'.$row['Notes'].'</text>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                    if ($type == 2 || $type == 5 || $type == 6)
                        echo  '<center><input type = "submit" class = "submitButton" value = "Remove Symptoms"></center>';
                    ?>

                </form>
            </div>
        </div>

        <!-- Add Medical Record -->
        <div class="subsection" <?php if ($type == 4) echo 'style="display:block;"'; ?>>
            <center><h2>Add Medical Record</h2></center>
            <button class="showHideButton" onclick="showHide('uploadFiles', this)">x</button>
            <div class="sectionContent" id="uploadFiles">
                <form action="uploadFile.php" method="post" enctype="multipart/form-data">
                    <div class="sectionLine">
                        File:
                        <input type="file" class="sectionLineInput" style = "width: 300" name="file">
                    </div>
                    <input type="hidden" name="patId" <?php echo "value='".$_GET["patient_ID"]."'" ?> >
                    Notes:
                    <textarea id="notes" style="width: 100%;background-color:#F3F3F3" name="notes"></textarea>
                    <center><input type="submit" class="submitButton" value="Upload File"></center>
                </form>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Medical History</h2></center>
            <button class="showHideButton" onclick="showHide('downloadFile', this)">x</button>
            <div class="sectionContent" id="downloadFile">
                <div class = "overflow" style = "max-height:400px;">
                    <form action="DownFile.php" method="post">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM UploadFiles WHERE userId = '".$_GET["patient_ID"]."'ORDER BY _id DESC";
                        $result=$conn->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $file = $row["sysName"];
                                $filepath = "/HealthLinkCSE360/PHP/uploads/".basename($file);
                                echo '<div class="appointmentBox">';
                                echo '<a style = "color: #00B74A" href = "'.$filepath.'">'.$row['origName'].'</a>';
                                echo ' <text class = "o3">'.$row['uploadTime'].'</text>';
                                if ($row['notes']) echo '<br><text class = "p1">'.$row['notes'].'</text>';
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
        <div class="subsection" <?php if ($type == 2 || $type == 6) echo 'style="display:block;"'; ?>>
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
                            echo 'Medication: <text class = "p1">'.$row['Medication'].'</text> ';
                            echo 'Date: <text class = "o3">'.$row['Date'].'</text> ';

                            echo '<br><a class = "g1" href = "view_prescription.php?prescriptionID='.$row['_id'].'">View/Print Prescription</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no prescriptions.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 2 || $type == 6) echo 'style="display:block;"'; ?>>
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
                            echo '<br>Description: <text class = "b2">'.$row['Description'].'</text>';
                            if ($type == 3) echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
                            else echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">View Lab Report</a>';
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
                            echo 'Labwork Title: <text class = "o3">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            if ($type == 3) echo '<br><a class = "g1" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no pending lab reports.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="subsection" <?php if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6) echo 'style="display:block;"'; ?>>
            <center><h2>Emergency Ward</h2></center>
            <button class="showHideButton" onclick="showHide('Alerts', this)">x</button>
            <div class="sectionContent" id="Alerts">
                <h3>Upcoming Visits</h3>
                <div class = "overflow">
                    <?php
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM EmergencyAppointments WHERE Datetime < '".$now."'AND PatientID = '".$patientID."' ORDER BY Datetime DESC";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $sql = "SELECT * FROM UserData WHERE _id ='".$row['PatientID']."'";
                            $x = $conn->query($sql);
                            $y = $x->fetch_assoc();
                            $name = $y['FirstName']. ' '.$y['LastName'];
                            echo '<div class="appointmentBox">';
                            echo '<text class = "p1">'.$name.'</text> ';
                            echo ' on <text class = "o3">'.$row['Date'].'</text>'.' at '.'<text class = "o3">'.$row['Time'].'</text>';
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
                    $sql = "SELECT * FROM EmergencyAppointments WHERE Datetime >= '".$now."'AND PatientID = '".$patientID."' ORDER BY Datetime DESC";
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
    </div>


</div>
</body>
</html>