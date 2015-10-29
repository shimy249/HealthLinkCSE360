<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/27/2015
 * Time: 6:12 PM
 */
session_start();
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
        <h1>IPMS - Patient Case - <?php echo $patientName; ?></h1>
        <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
            Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
            <a href = "homepage.php" style = "color: 00B74A;">Home page</a> | <a href = "logout.php" style = "color: 3BA3D0;">Log out</a>
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
                        <div class="sectionLine">Physical Address: <text class = "p1"><?php echo $patientRow['Email'];?></text></div>
                    </form>
                </div>
            </div>


            <div class="subsection"<?php if ($type == 0 || $type == 1) echo 'style="display:block;"'; ?>>
                <center><h2>Patient Appointments</h2></center>
                <button class="showHideButton" onclick="showHide('ManageAppointments', this)">x</button>
                <div class="sectionContent" id="ManageAppointments">
                    <form>
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
                                echo '<input type="checkbox" value="0" style="position:absolute; left:5px; top:14px;">';
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
                        echo mysqli_error($conn);
                        ?>
                        <center><input type="submit"  class="submitButton"  value="Cancel Selected Appointments" action="submit"></center>

                    </form>
                </div>
            </div>
        </div>


</div>
</body>
</html>
