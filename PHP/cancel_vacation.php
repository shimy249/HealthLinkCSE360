<?php

ob_start();
session_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
date_default_timezone_set ('America/Phoenix');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    foreach ($_POST['vacations'] as $vacationID) {
        $sql = "DELETE FROM Vacations WHERE _id='" . $vacationID."'";
        $result = $conn->query($sql);
    }
    header("Location: homepage.php");
}
?>