<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/30/2015
 * Time: 7:45 AM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

$sql = "SELECT * FROM UserData WHERE _id='".$_POST['userID']."'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();

if (!($_POST['a1']==$row['a1'] && $_POST['a2']==$row['a2'] && $_POST['a3']==$row['a3'])){
    $_SESSION['notification'] = 'The answers you entered were incorrect';
    header("Location: index.php");
    return;
}

$_SESSION["type"] = $row["Type"];
$_SESSION["user"] = $row["UserName"];
$_SESSION["userID"] = $row["_id"];
$_SESSION['notification'] = "Welcome ".$row['FirstName'];
header("Location: homepage.php");

?>