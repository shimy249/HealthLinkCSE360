<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/22/2015
 * Time: 6:51 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$conn = mysqli_connect('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    echo "Connect successfully";



    $user = $_SESSION["user"];
    $type = $_SESSION["type"];
    $firstname = $_POST['profile_FirstName'];
    $lastname = $_POST['profile_LastName'];
    $email = $_POST['profile_Email'];
    $username = $_POST['profile_Username'];
    $password = $_POST['profile_Password'];
    $dob = $_POST['profile_DateOfBirth'];
    $ssn = $_POST['profile_SocialSecurity'];
    $gender = $_POST['profile_Gender'];
    $address = $_POST['profile_Address'];
    $q1 = $_POST['profile_Question1'];
    $a1 = $_POST['profile_Answer1'];
    $q2 = $_POST['profile_Question2'];
    $a2 = $_POST['profile_Answer2'];
    $q3 = $_POST['profile_Question3'];
    $a3 = $_POST['profile_Answer3'];

    if ($firstname == '' || $lastname == '' || $email == '' || $username == '' || $password == '' || $dob == '' || $ssn == '' || $gender == '' || $address == '' || $q1 == '' || $a1 == '' || $q2 == '' || $a2 == '' || $q3 == '' || $a3 == ''){
        $_SESSION['notification'] = 'Please fill out all fields to update your profile';
        header("Location: homepage.php");
        return;
    }

    $sql = "UPDATE UserData SET FirstName='" . $firstname . "',LastName='" . $lastname . "', DOB='" . $dob . "', Gender='" . $gender . "', SSN='" . $ssn . "', Phone='" . $phone . "', Email='" . $email . "', UserName='" . $username . "',Password='" . $password . "',Address='" . $address . "',Type='" . $type . "',q1='" . $q1 . "',a1='" . $a1 . "',q2='" . $q2 . "',a2='" . $a2 . "', q3='" . $q3 . "',a3='" . $a3 . "' WHERE UserName='" . $user . "'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['notification'] = "Personal Information updated successfully";
        $_SESSION["user"] = $username;
        $url = "homepage.php";
        header("Location: ".$url);
        return;
    } else {
        $_SESSION['notification'] = "Error updating record: " . $conn->error;
    }
}
?>