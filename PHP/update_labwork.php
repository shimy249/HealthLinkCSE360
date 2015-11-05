<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$labworkID = $_GET['labworkID'];
$notification = $_SESSION['notification'];
$target_dir = getcwd()."/uploads/";
if(isset($_SESSION['notification'])) unset($_SESSION['notification']);

$report = nl2br($_POST['report']);

if(isset($_FILES['ufile'])){
    $unique_name = $target_dir . basename(uniqid() . $_FILES['ufile']['name']);

    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "INSERT INTO LabAttachemnts(origName, sysName, labReportId) VALUES('". $_FILES['ufile']['name']."', '". $unique_name."','". $labworkID. "')";
    echo $sql;
    $conn->query($sql);
    if(move_uploaded_file($_FILES['ufile']['tmp_name'], $unique_name)){

    }
    else{
        echo "Error occured";
    }
}

$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "UPDATE Labwork SET Report = '".$report."'" ."WHERE _id='". $labworkID."'";
$conn->query($sql);

header("Location: view_labwork.php?labworkID=".$labworkID);
?>