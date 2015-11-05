<?php

ob_start();
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$labworkID = $_GET['labworkID'];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    foreach ($_POST['files'] as $files) {
        $sql = "DELETE FROM LabAttachemnts WHERE _id='" . $files."'";
        $result = $conn->query($sql);
    }
    header("Location: view_labwork.php?labworkID=".$labworkID);
}
?>