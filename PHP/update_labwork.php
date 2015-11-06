<?php
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {return;}
$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$labworkID = $_GET['labworkID'];
$notification = $_SESSION['notification'];
$target_dir = getcwd()."/uploads/";
if(isset($_SESSION['notification'])) unset($_SESSION['notification']);
$_SESSION['resultText'] = $_POST['resultText'];
$report = nl2br($_POST['report']);

if($_POST['bSave']){
    echo 'save';
    $sql = "UPDATE Labwork SET Report = '".$report."' WHERE _id='". $labworkID."'";
    $conn->query($sql);
}
else if ($_POST['bAttach']){
    echo 'attach';
    if(isset($_FILES['ufile']) && $_FILES['ufile']){
        $unique_name = $target_dir . basename(uniqid() . $_FILES['ufile']['name']);

        $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
        $sql = "INSERT INTO LabAttachemnts(origName, sysName, labReportId) VALUES('". $_FILES['ufile']['name']."', '". $unique_name."','". $labworkID. "')";
        echo $sql;
        $conn->query($sql);
        if(move_uploaded_file($_FILES['ufile']['tmp_name'], $unique_name)){

        }
        else{
            echo "Error occured";
        }
    }
}
else if ($_POST['bPublish']){
    echo 'publish';
    $sql = "UPDATE Labwork SET Published = '1',Report = '".$report."' WHERE _id='". $labworkID."'";
    $conn->query($sql);
}
else if ($_POST['bRemove']){
    echo 'remove';
    if($conn) {
        foreach ($_POST['files'] as $files) {
            $sql = "DELETE FROM LabAttachemnts WHERE _id='" . $files."'";
            $result = $conn->query($sql);
        }
        header("Location: view_labwork.php?labworkID=".$labworkID);
    }
}

header("Location: view_labwork.php?labworkID=".$labworkID);
?>