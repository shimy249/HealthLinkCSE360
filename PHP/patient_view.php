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
        <h1>IPMS - Patient View - <?php echo $patientName; ?></h1>
        <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
            Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
            <a href = "logout.php"><text class="b4">Log out</text></a>
        </div>
        <div id="notifications" style="width:100%;text-align:center;">
            <text class="b4"><?php echo $notification ?></text>
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
        </div>
    </div>


</div>
</body>
</html>
