<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 3:32 AM
 */

session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];

$doctorID = $_POST['schedule_Doctor'];
$date = $_POST['schedule_Date'];
$time = $_POST['schedule_Time'];
$patient = $user;
$diseaseID = $_SESSION['diseaseID'];
if ($time == '' || $doctorID == '' || $date == ''){
    $_SESSION['notification'];
    header('Location: homepage.php');
    return;
}

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {

    $diagnosis = "None";

    $sql = "SELECT * FROM DiseaseDefinitions WHERE _id='".$diseaseID."'";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        $row = $result->fetch_assoc();
        $diagnosis = $row['Name'];
    }
    //insert appointment
    $sql = "INSERT INTO Appointments(PatientID, DoctorID,Date, Hour, Diagnosis) VALUES ('$userID', '$doctorID', '$date', '$time', '$diagnosis')";
    $conn->query($sql);
    $_SESSION['notification'] = 'Your appointment has been created.';
    header('Location: homepage.php?');
}
else
    echo 'Connect failed';

?>