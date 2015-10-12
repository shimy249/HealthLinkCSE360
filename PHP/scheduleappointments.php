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


    $doctor = $_POST['schedule_Doctor'];
    $month = $_POST['schedule_Month'];
    $day = $_POST['schedule_Day'];
    $year = $_POST['schedule_Year'];
    $time = $_POST['schedule_Time'];
    $patient = $_GET["user"];

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
    $sql = "INSERT INTO Appointments(Doctor, Month, Day, Year, Time, Patient) VALUES ('$doctor', '$month', '$day', '$year', '$time', '$patient')";
    $conn->query($sql);
}

else
    echo 'Connect failed';

?>
