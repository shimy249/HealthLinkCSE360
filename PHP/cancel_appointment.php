<?php

ob_start();
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    foreach ($_POST['appointments'] as $appointments) {
        $sql = "DELETE FROM Appointments WHERE _id='" . $appointments."'";
        $result = $conn->query($sql);
    }
    header("Location: homepage.php");
}
?>