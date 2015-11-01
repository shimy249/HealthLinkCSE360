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
$sql = "SELECT * FROM Labwork WHERE _id = '".$labworkID."'";
$result=$conn->query($sql);
if($result->num_rows == 0){
    $_SESSION['notification'] = "This prescription does not exist.";
    header("Location: homepage.php");
}
$Labwork = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '".$Labwork['PatientID']."'";
$result=$conn->query($sql);
if($result->num_rows == 0){
    $_SESSION['notification'] = "This prescription is invalid, please contact your doctor";
    header("Location: homepage.php");
}
$Patient = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '".$Labwork['DoctorID']."'";
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
    <title>IPMS - Home </title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php

?>
<div class="main">
    <h1>Labwork Results</h1>
    <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification ?></text>
    </div>


    <div class = "subsection" style="display: block; margin: 0 auto; width: 600px; top: 25px;padding-right:10px;padding-bottom: 10px;">
        <center><h2>Labwork Results - <?php echo $Labwork['Title'];?></h2></center>
        <h3>Patient</h3> <?php echo $Patient['FirstName'] .' '.$Patient['LastName'] ;?>
        <h3>Doctor</h3> <?php echo $Doctor['FirstName'] .' '.$Doctor['LastName'] ;?>
        <h3>Date</h3> <?php echo $Labwork['Date'];?>
        <h3>Description</h3> <?php echo $Labwork['Description'];?>
        <h3>Results</h3> <?php if ($type != 3) echo $Labwork['Report'];?>
        <form action="update_labwork.php?labworkID=<?php echo $labworkID; ?>" method = "post" <?php if ($type != 3) echo 'style="display:none"';?>>
            <textarea style = "width: 100%; height: 300px;" name = "report"><?php echo $Labwork['Report'];?></textarea>
            <center><input type = "submit" class = "submitButton" value = "Save"</center>
        </form>
    </div>





</div>
</body>
</html>