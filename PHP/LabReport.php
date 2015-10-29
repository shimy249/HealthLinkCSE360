<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/5/2015
 * Time: 11:04 PM
 */
ob_start();
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $patient = $_POST['patient'];
    $patient = str_replace('\'', "", $patient);
    $doctor = $_POST['doctor'];
    $doctor = str_replace('\'', "", $doctor);
    $month = $_POST['month'];
    $day = $_POST['day'];
    $year = $_POST['year'];
    $datetime = $year . '-' . $month . '-' . $day . ' ' . $time . ':00:00';

    $report = $_POST['report'];
    //get staffid
    $sql = "SELECT * FROM UserData WHERE Name='" . $patient . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $userID = $row["_id"];
        }
    }

    $sql = "SELECT * FROM UserData WHERE Name='" . $doctor . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $StaffID = $row["_id"];
        }
    }

    $sql = "INSERT INTO LabRecords(PatientID, StaffID, StartTime, EndTime) VALUES ('$userID', '$patientID', '$datetime','$report')";

}

?>
