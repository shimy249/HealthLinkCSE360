<?php
/**
 * Created by PhpStorm.
 * User: Ashley
 * Date: 10/8/2015
 * Time: 8:58 PM
 */
ob_start();
session_start();
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

if($conn) {



    $doctorID = $_POST['schedule_Doctor'];
    $month = $_POST['schedule_Month'];
    $day = $_POST['schedule_Day'];
    $year = $_POST['schedule_Year'];
    $time = $_POST['schedule_Time'];
    $patient = $user;

    $datetime = $year.'-'.$month.'-'.$day.' '.$time.':00:00';

    $time++;

    $endt = $year.'-'.$month.'-'.$day.' '.$time.':00:00';

    //get staffid

    $sql = "SELECT * FROM UserData WHERE _id='" . $doctorID . "'";
    $result = $conn->query($sql);

    $staffID;
    $userID;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staffID = $row["_id"];
    }
    //get userid
    $sql = "SELECT * FROM UserData WHERE UserName='" . $user . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
            $userID = $row["_id"];


    }
    echo $userID . ' ' . $doctorID;
    //insert appointment
    $sql = "INSERT INTO Appointments(PatientID, StaffID,StartTime, EndTime) VALUES ('$userID', '$doctorID', '$datetime', '$endt')";
    $conn->query($sql);
    $url = "homepage.php?user=".$patient;
    //header('Location: homepage.php?user='.$patient);

}

else
    echo 'Connect failed';

?>
