<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/22/2015
 * Time: 6:51 PM
 */
ob_start();
session_start();
$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0');

if($conn) {
    echo "Connect successfully";

    $conn = mysqli_connect('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

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

    $sql = "UPDATE UserData SET FirstName='" . $firstname . "',LastName='" . $lastname . "', DOB='" . $dob . "', Gender='" . $gender . "', SSN='" . $ssn . "', Phone='" . $phone . "', Email='" . $email . "', UserName='" . $username . "',Password='" . $password . "',Address='" . $address . "',Type='" . $type . "',q1='" . $q1 . "',a1='" . $a1 . "',q2='" . $q2 . "',a2='" . $a2 . "', q3='" . $q3 . "',a3='" . $a3 . "' WHERE UserName='" . $user . "'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        $url = "homepage.php";
        header("Location: ".$url);
    } else {
        echo "Error updating record: " . $conn->error;
    }
   mysqli_close($conn);
}
?>