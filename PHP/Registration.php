<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/5/2015
 * Time: 11:04 PM
 */

$sql = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0');

if($sql)
{
    echo "Connect successfully";

    mysqli_select_db($sql,'appbfdlk_HealthLinkCSE360');

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
    $a3 =  = $_POST['profile_Answer3'];

    $insert = "INSERT INTO UserData (Firstname, Lastname, Email, Username, Password, DOB, SSN, Gender, Address, Q1, A1, Q2, A2, Q3, A3)
    VALUES ('$firstname', '$lastname', '$email', '$username', '$password', '$dob', '$ssn', '$gender', '$address', '$q1', '$a1', '$q2', '$a2', '$q3', '$a3')";

    if (mysqli_query($sql, $insert))
        echo "Registered Successfully";
    else
        echo "Error: " . $insert . "<br>" . mysqli_error($sql);

    mysqli_close($sql);
}
else
    echo "Connection failed";


?>
