<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/31/15
 * Time: 7:36 PM
 */
session_start();
ob_start();
$target_dir = getcwd()."/uploads/";

if(isset($_FILES['file'])){

    $unique_name = $target_dir . basename(uniqid() . $_FILES['file']['name']);

    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "INSERT INTO UploadFiles(origName, sysName, userId) VALUES('". $_FILES['file']['name']."', '". $unique_name."','". $_POST['patId']. "')";
    echo $sql;
    $conn->query($sql);
    if(move_uploaded_file($_FILES['file']['tmp_name'], $unique_name)){
        header("Location: patient_view.php?patient_ID=".$_POST['patId']);
    }
    else{
        echo "Error occured";
    }
}

?>