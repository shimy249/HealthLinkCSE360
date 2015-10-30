<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/29/2015
 * Time: 6:41 PM
 */
ob_start();
session_start();
$user = $_SESSION["user"];
$type = $_SESSION["type"];

$patientID = $_POST["patientID"];
$doctorID = $_POST["doctorID"];
$ts = getdate();
$date = $ts[year].'/'.$ts[mon].'/'.$ts[mday];
$title = $_POST['title'];
$description = $_POST['description'];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "INSERT INTO Labwork (PatientID,DoctorID,Date,Title,Description)
    VALUES ('$patientID','$doctorID', '$date', '$title', '$description')";
    if ($conn->query($sql)) {
        $_SESSION['notification'] = 'Your request for Labwork has been submitted.';
        header("Location: patient_view.php?patient_ID=".$patientID);
    }
    else{
        $_SESSION['notification'] = 'Your request for Labwork could not be submitted.';
        header("Location: patient_view.php?patient_ID=".$patientID);
    }
}
?>