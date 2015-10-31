<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 2:51 PM
 */
session_start();
date_default_timezone_set ('America/Phoenix');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
$symptom = $_POST['Symptom'];
$severity = $_POST['Severity'];
$notes = $_POST['Notes'];

if ($symptom == '' || $severity == ''){
    $_SESSION['notification'];
    header('Location: homepage.php');
    return;
}

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "INSERT INTO Conditions(PatientID, Symptom,Severity, Notes, Date) VALUES ('$userID', '$symptom', '$severity', '$notes', '$date')";
    $conn->query($sql);
    header('Location: homepage.php?');
    echo mysqli_error($conn);
}
else
    echo 'Connect failed';

?>