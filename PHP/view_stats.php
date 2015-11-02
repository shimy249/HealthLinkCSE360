<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$labworkID = $_GET['labworkID'];
$notification = $_SESSION['notification'];
if(isset($_SESSION['notification'])) unset($_SESSION['notification']);

$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

$sql = "SELECT * FROM UserData WHERE Type=1";
$res = $conn->query($sql);
$patientCount = $res->num_rows;

$sql = "SELECT * FROM UserData WHERE Type=1&&Gender LIKE 'm'";
$res = $conn->query($sql);
$male = $res->num_rows;

$sql = "SELECT * FROM UserData WHERE Type=1&&Gender LIKE 'f'";
$res = $conn->query($sql);
$female = $res->num_rows;


$sql = "SELECT * FROM UserData WHERE Type=2";
$res = $conn->query($sql);
$docCount = $res->num_rows;

$sql = "SELECT * FROM UserData WHERE Type=3";
$res = $conn->query($sql);
$staffCount = $res->num_rows;

$sql = "SELECT * FROM Appointments WHERE Date>=CURRENT_DATE";
$res = $conn->query($sql);
$aptCount = $res->num_rows;

$sql = "SELECT * FROM MedicalRecords";
$res = $conn->query($sql);
$recordCount = $res->num_rows;

$sql = "SELECT * FROM Conditions";
$res = $conn->query($sql);
$diagCount = $res->num_rows;

$sql = "SELECT * FROM Labwork WHERE Report IS NOT NULL";
$res = $conn->query($sql);
$labReport = $res->num_rows;

$sql = "SELECT * FROM Prescriptions";
$res = $conn->query($sql);
$prescriptions = $res->num_rows;


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
    <h1>IPIMS - Statistical Report</h1>
    <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification ?></text>
    </div>


    <div class = "subsection" style="display: block; margin: 0 auto; width: 600px; top: 25px;padding-right:10px;padding-bottom: 10px;">
        <center><h2>Statistical Report</h2></center>
        <h3>Number of Patients</h3> <?php echo $patientCount. "   (". $male. " male ". $female." female)";?>
        <h3>Number of Doctors</h3> <?php echo $docCount;?>
        <h3>Number of Other Medical Staff</h3> <?php echo $staffCount;?>
        <h3>Number of Future Appointments</h3> <?php echo $aptCount;?>
        <h3>Number of Medical Record Entries</h3> <?php echo $recordCount;?>
        <h3>Number of Diagnosis Issued</h3> <?php echo $diagCount;?>
        <h3>Number of Lab Reports Created</h3> <?php echo $labReport;?>
        <h3>Number of Prescriptions Issued</h3> <?php echo $prescriptions;?>

    </div>





</div>
</body>
</html>