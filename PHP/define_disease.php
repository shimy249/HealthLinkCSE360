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
$name = $_POST['name'];
$symptoms = $_POST['symptoms'];
$emergency = $_POST['emergency'];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    $sql = "SELECT * FROM DiseaseDefinitions WHERE Name = '".$name."'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0){
        $sql = "INSERT INTO DiseaseDefinitions (Name, SymptomList,Emergency) VALUES ('$name', '$symptoms', '$emergency')";
        $conn->query($sql);
        $_SESSION['notification'] = 'This disease has been added to the defined diseases.';
    }
    else {
        $sql = "UPDATE DiseaseDefinitions SET Name='".$name."',SymptomList='".$symptoms."',Emergency='".$emergency."' WHERE Name = '".$name."'";
        $conn->query($sql);
        $_SESSION['notification'] = 'This disease has been added to the defined diseases.';
    }
    header("Location: admin_home.php");
}