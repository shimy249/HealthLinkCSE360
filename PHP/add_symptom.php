<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 2:51 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];
$patientID = $_POST['patientID'];
$source = $_POST['source'];
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
$symptom = $_POST['Symptom'];
$severity = $_POST['Severity'];
$notes = $_POST['Notes'];

echo $userID. $symptom. $severity. $notes. $date;

if ($symptom == '' || $severity == ''){
    $_SESSION['notification'];
    header("Location: ".$source);
    return;
}
if ($symptom == ""){
    $_SESSION['notification'] = "Please select a symptom";
    header("Location: ".$source);
    return;
}
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "INSERT INTO Conditions(PatientID, Symptom,Severity, Notes, Date) VALUES ('$patientID', '$symptom', '$severity', '$notes', '$date')";
    $conn->query($sql);
    header("Location: ".$source);
    echo mysqli_error($conn);
}
else
    echo 'Connect failed';

?>