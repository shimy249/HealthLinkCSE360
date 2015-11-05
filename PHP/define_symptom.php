<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/4/2015
 * Time: 7:14 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];
$symptom = $_POST['symptom'];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "SELECT * FROM AllSymptoms WHERE Name = '".$symptom."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0){
        $sql = "INSERT INTO AllSymptoms(Name) VALUES ('$symptom')";
        $conn->query($sql);
        $_SESSION['notification'] = 'This symptom has been added to the defined symptoms.';
    }
    else $_SESSION['notification'] = 'This symptom already exists.';
    header("Location: admin_home.php");
}