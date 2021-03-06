<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$prescriptionID = $_GET['prescriptionID'];
$notification = $_SESSION['notification'];
if(isset($_SESSION['notification'])) unset($_SESSION['notification']);

$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "SELECT * FROM Prescriptions WHERE _id = '".$prescriptionID."'";
$result=$conn->query($sql);
if($result->num_rows == 0){
    $_SESSION['notification'] = "This prescription does not exist.";
    header("Location: homepage.php");
}
$Prescription = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '".$Prescription['PatientID']."'";
$result=$conn->query($sql);
if($result->num_rows == 0){
    $_SESSION['notification'] = "This prescription is invalid, please contact your doctor";
    header("Location: homepage.php");
}
$Patient = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '".$Prescription['DoctorID']."'";
$result=$conn->query($sql);
if($result->num_rows == 0){
    $_SESSION['notification'] = "This prescription is invalid, please contact your doctor";
    header("Location: homepage.php");
}
$Doctor = $result->fetch_assoc();
?>

<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>IPIMS - View Prescription</title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php

?>
<div class="main">
    <h1>IPIMS - View Prescription</h1>
    <div style="position:absolute;right:15px;top:10px;color:black;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="o4"><b><?php echo $notification ?></b></text>
    </div>


    <div class = "subsection" style="display: block; margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;">
        <center><h2>Electronic Prescription - Interactive Patient Management System</h2></center>
        <h3>Patient</h3>
        <?php
        echo $Patient['FirstName'] .' '.$Patient['LastName'].'<br>' ;
        echo $Patient['Address'] .', '.$Patient['City'].', ' .$Patient['State'].' '.$patient['Zip'] ;
        echo '<br>DOB: '.$Patient['DOB'];
        ?>
        <h3>Doctor</h3> <?php echo $Doctor['FirstName'] .' '.$Doctor['LastName'] ;?>
        <h3>Date</h3> <?php echo $Prescription['Date'];?>
        <h3>Pharmacy Instructions</h3>Drug: <?php echo $Prescription['Medication'];?><br> <?php echo $Prescription['Instructions'];?>
        <center><button class="submitButton" onclick="window.print();">Print Prescription</button></center>
    </div>





</div>
</body>
</html>