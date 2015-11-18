<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/4/2015
 * Time: 12:09 AM
 */
ob_start();
session_start();
$conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$_SESSION['diseaseID'] =  $_POST['selected_disease'];
$diseaseID = $_POST['selected_disease'];
$symptom = $_POST['symptom'];
$userID = $_SESSION['userID'];
$url = '';
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
if ($diseaseID > 0){

    $sql = "SELECT * FROM DiseaseDefinitions WHERE _id = '".$diseaseID."'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['Emergency']== 1){ //emergency condition
        //echo 'emergency';
        $url = 'appointment_page.php';
    }
    else { //general condition
        $url = 'appt_general.php?';
    }
    $symptomList = $row['SymptomList'];
    $aSymptoms = explode(", ", $symptomList);
    foreach ($aSymptoms as $i){
        $sql = "INSERT INTO Conditions(PatientID, Symptom,Severity, Notes, Date) VALUES ('$userID', '$i', 3, 'Added by appointment tool', '$date')";
        $conn->query($sql);
    }
}else{ //no condition
    $url = 'appt_general.php?';
    if ($symptom) {
        $sql = "INSERT INTO Conditions(PatientID, Symptom,Severity, Notes, Date) VALUES ('$userID', '$symptom', 3, 'Added by appointment tool', '$date')";
        $conn->query($sql);
    }
}
echo $url;
header("Location: ".$url);