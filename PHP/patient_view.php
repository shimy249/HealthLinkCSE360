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
                    Date Of Birth (MM/DD/YYYY): <text class = "p1"><?php echo $patientRow['DOB'];?></text><br>
                    Social Security Number: <text class = "p1"><?php echo $patientRow['SSN'];?></text><br>
                    Gender: <text class = "p1"><?php echo $patientRow['Gender'];?></text><br>
                    Physical Address: <text class = "p1"><?php echo $patientRow['Address'];?></text><br>
                </form>
            </div>
        </div>


        <div class="subsection"<?php if ($type == 1 || $type == 2) echo 'style="display:block;"'; ?>>
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
                                        if ($type == 1) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 2) echo 'Patient: <text class="p1">' . $patient . '</text>';
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
                                        echo "<div class='appointmentBox'>";
                                        echo '<input name = "appointments[]" type="checkbox" value="' . $row['_id'] . '" class = "selectBox">';
                                        echo 'Date: <text class="o3">' . $date . '</text> ';
                                        echo 'Time: <text class="o3">' . $time . '</text><br>';
                                        if ($type == 1) echo 'Doctor: <text class="p1">' . $staff . '</text>';
                                        else if ($type == 2) echo 'Patient: <text class="p1">' . $patient . '</text>';
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

        <div class="subsection" <?php if ($type == 2 || $type ==3 || $type == 5) echo 'style="display:block;"'; ?>>
            <center><h2>Patient Symptoms</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="diagnosis.php" method="post">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Conditions WHERE PatientID='".$patientID."'";
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
                </form>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 2 || $type == 3 || $type == 4) echo 'style="display:block;"'; ?>>
            <center><h2>Diagnosis Results</h2></center>
            <button class="showHideButton" onclick="showHide('CurrentHealthConcerns', this)">x</button>
            <div class="sectionContent" id="CurrentHealthConcerns">
                <form action="diagnosis.php" method="post">
                    <div class = "overflow">
                        <?php
                        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM Diagnosis WHERE PatientID='".$patientID."' ORDER BY Date DESC" ;
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

        <div class="subsection" <?php if ($type == 2 || $type == 3 || $type == 4) echo 'style="display:block;"'; ?>>
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
        <div class="subsection" <?php if ($type == 2) echo 'style="display:block;"'; ?>>
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
                    <textarea name = "instructions" type = "text" style = "width: 100%; height: 100px;font-size:inherit; background-color: #F2F2F2">Strength: &#13;&#10;Form: &#13;&#10;Quantity: &#13;&#10;Dosage: &#13;&#10;Refills: &#13;&#10;Additional Instructions: </textarea>

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
                            echo 'Medication: <text class = "o3">'.$row['Medication'].'</text> ';
                            echo '<br><a style = "color:#00B74A;" href = "view_prescription.php?prescriptionID='.$row['_id'].'">View/Print Prescription</a>';
                            echo '</div>';
                        }
                    }
                    else echo 'There are no prescriptions.<br><br>'
                    ?>
                </div>
            </div>
        </div>

        <div class="subsection" <?php if ($type == 2) echo 'style="display:block;"'; ?>>
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
                            echo 'Labwork Title: <text class = "o3">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            if ($type == 3) echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Edit Lab Report</a>';
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
                            echo 'Labwork Title: <text class = "o3">'.$row['Title'].'</text>';
                            echo '<br>Description: <text class = "p1">'.$row['Description'].'</text>';
                            if ($type == 4) echo '<br><a style = "color:#00B74A;" href = "view_labwork.php?labworkID='.$row['_id'].'">Complete Lab Report</a>';
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