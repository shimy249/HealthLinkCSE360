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
$url = '';
if ($diseaseID > 0){

    $sql = "SELECT * FROM DiseaseDefinitions WHERE _id = '".$diseaseID."'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['Emergency']== 1){ //emergency condition
        $url = 'appointment_page.php';
    }
    else { //general condition
        $url = 'appt_general.php?';
    }
}else{ //no condition
    $url = 'appt_general.php?';
}

header("Location: ".$url);