<?php
/**
 * Created by PhpStorm.
 * User: Ashley
 * Date: 10/8/2015
 * Time: 8:58 PM
 */

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

if($conn) {
    echo "Connect successfully";


    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $staff = $_POST["staff"];
    $user = $_GET["user"];

    //get staffid
    $sql = "SELECT * FROM UserData WHERE UserName='" . $staff . "'";
    $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $staffID = $row["_id"];
        }

    }
    //get userid
    $sql = "SELECT * FROM UserData WHERE UserName='" . $user . "'";
    $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $userID = $row["_id"];
        }

    }

    //insert appointment
    $sql = "INSERT INTO Appointments('PatientID', 'StaffID', 'StartTime', 'EndTime') VALUES ('$userID','$staffID', '$startTime', '$endTime')";
    $conn->query($sql);
}

else
    echo 'Connect failed';

?>