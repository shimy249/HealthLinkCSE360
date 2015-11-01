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
if(isset($_SESSION['notification'])) unset($_SESSION['notification']);

$report = nl2br($_POST['report']);
$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "UPDATE Labwork SET Report = '".$report."'";
$conn->query($sql);
header("Location: view_labwork.php?labworkID=".$labworkID);
?>