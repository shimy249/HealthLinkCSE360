<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 11/17/15
 * Time: 11:47 PM
 */



ob_start();
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$file = $_POST["X"];
if($conn) {

        $sql = "DELETE FROM UploadFiles WHERE sysName='" . $file."'";
        $result = $conn->query($sql);

    header("Location: patient_view.php?patient_ID=".$_GET['patient_ID']);
}
?>