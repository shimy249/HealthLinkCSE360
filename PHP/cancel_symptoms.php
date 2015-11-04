<?php

ob_start();
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$source = $_POST['source'];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    foreach ($_POST['symptom'] as $concern) {
        $sql = "DELETE FROM Conditions WHERE _id='" . $concern."'";
        $result = $conn->query($sql);
    }
    header("Location: ".$source);
}
?>