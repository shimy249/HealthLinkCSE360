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
$medication = $_POST['medication'];
$instructions = nl2br($_POST['instructions']);
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "INSERT INTO Prescriptions (PatientID,DoctorID,Date,Medication,Instructions)
    VALUES ('$patientID','$doctorID', '$date', '$medication', '$instructions')";
    if ($conn->query($sql)) {
        $_SESSION['notification'] = 'Your patient prescription was successfully created.';
        header("Location: patient_view.php?patient_ID=".$patientID);
    }
    else{
        $_SESSION['notification'] = 'The prescription could not be created';
        header("Location: patient_view.php?patient_ID=".$patientID);
    }
}
?>