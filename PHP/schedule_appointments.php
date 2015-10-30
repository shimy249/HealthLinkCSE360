<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 3:32 AM
 */

ob_start();
session_start();
date_default_timezone_set ('America/Phoenix');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];

$doctorID = $_POST['schedule_Doctor'];
$date = $_POST['schedule_Date'];
$time = $_POST['schedule_Time'];
$patient = $user;

if ($time == '' || $doctorID == '' || $date == ''){
    $_SESSION['notification'];
    header('Location: homepage.php');
    return;
}

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {

    $sql = "SELECT * FROM UserData WHERE _id='" . $doctorID . "'";
    $result = $conn->query($sql);
    //insert appointment
    $sql = "INSERT INTO Appointments(PatientID, DoctorID,Date, Hour) VALUES ('$userID', '$doctorID', '$date', '$time')";
    $conn->query($sql);
    $_SESSION['notification'] = 'Your appointment has been created.';
    header('Location: homepage.php?');
}
else
    echo 'Connect failed';

?>