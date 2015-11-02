<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/5/2015
 * Time: 11:04 PM
 */

session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

if($conn)
{
    echo "Connect successfully";

    //assign post data to local vars
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
    $type = $_POST['profile_Type'];
    //check if any of the fields are blank
    if ($firstname == '' || $lastname == '' || $email == '' || $username == '' || $password == '' || $dob == '' || $ssn == '' || $gender == '' || $address == '' || $q1 == '' || $a1 == '' || $q2 == '' || $a2 == '' || $q3 == '' || $a3 == ''){
        $_SESSION['notification'] = 'Please fill out all fields to register';
        header("Location: index.php");
        return;
    }
    //check if the username exists
    $sql = "SELECT * FROM UserData WHERE UserName='" . $username."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['notification'] = 'This username is already taken, please try again';
        header("Location: index.php");
        return;
    }
    //check if email exists
    $sql = "SELECT * FROM UserData WHERE Email='" . $email."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['notification'] = 'This email address is already taken, please try again';
        header("Location: index.php");
        return;
    }
    //insertion query creating new instance
    $sql = "INSERT INTO UserData (FirstName,LastName, DOB, Gender, SSN, Phone, Email, UserName,Password,Address,Type,q1,a1,q2,a2, q3,a3 )
    VALUES ('$firstname','$lastname', '$dob', '$gender', '$ssn', '$phone', '$email', '$username', '$password','$address',$type, '$q1','$a1','$q2','$a2','$q3','$a3')";


    if ($conn->query($sql)) {
        $_SESSION['notification'] = 'Your account was successfully created. You may now log in.';
        header("Location: index.php");
        return;
    }
    else {
        $_SESSION['notification'] = 'Registration Issue, please try again.';
        header("Location: index.php");
        return;
    }
    return;
}
else
    echo "Connection failed";


?>
