<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/4/2015
 * Time: 3:09 AM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];
$datetime = explode('T',$_POST['datetime']);
$date = $datetime[0];
$time = $datetime[1];
echo $date;
echo $time;
echo $datetime;
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {

    $diagnosis = "None";

    $sql = "SELECT * FROM DiseaseDefinitions WHERE _id='" . $diseaseID . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $diagnosis = $row['Name'];
    }
    $sql = "INSERT INTO EmergencyAppointments (PatientID,Diagnosis, Date, Time) VALUES ('$userID', '$diagnosis','$date','$time')";
    $conn->query($sql);
    $_SESSION['notification'] = 'Your emergency appointment has been created, the emergency ward will be expecting your arrival at '.$time.' on '.$date;
    header('Location: homepage.php?');

}
?>