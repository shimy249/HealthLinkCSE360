<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 5:01 AM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];

$startDate = $_POST['startDate'];
$endDate= $_POST['endDate'];
$aStart = strtotime($startDate);
$aEnd = strtotime($endDate);

if ($aStart > $aEnd){
    $_SESSION['notification'] = "The start date must come before the end date.";
    header('Location: homepage.php?');
    return;
}

$abort = false;
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "SELECT * FROM Vacations WHERE DoctorID = '".$userID."'";
    $result=$conn->query($sql);
    if($result->num_rows>0) {

        while ($row = $result->fetch_assoc()) {
            $bStart = strtotime($row['StartDate']);
            $bEnd = strtotime($row['EndDate']);
            if (!(($aStart < $bStart && $aEnd < $bStart) || ($aStart > $bEnd && $aEnd > $bEnd))){
                $_SESSION['notification'] = "This vacation overlaps with an existing vacation, and cannot be scheduled.";
                header('Location: homepage.php?');
                return;
            }
        }
    }
    $sql = "INSERT INTO Vacations(DoctorID,StartDate, EndDate) VALUES ('$userID', '$startDate', '$endDate')";
    $conn->query($sql);
    $sql = "DELETE FROM Appointments WHERE DoctorID = '".$userID."' AND Date >= '".$startDate."' AND  Date <= '".$endDate."'";
    $conn->query($sql);
    $_SESSION['notification'] = 'Your vacation has been scheduled.';
    header('Location: homepage.php?');
}


?>