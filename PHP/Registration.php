<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/5/2015
 * Time: 11:04 PM
 */

ob_start();
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
    $a3 = $_POST['profile_Answer3'];

    $format="m/d/y";
    $dob=strptime(dob, $format);
    $dob=date("Y-m-d", $dob);

    $name=$firstname." ".$lastname;

    $insert = "INSERT INTO UserData (Name, DOB, Gender, SSN, Phone, Email, UserName,Password,Address,Type)
    VALUES ('$name', '$dob', '$gender', '$ssn', '$phone', '$email', '$username', '$password','$address','Patient')";


    if (mysqli_query($sql, $insert)) {
        echo "Registered Successfully";
        echo $insert;
        $url = "index.php";
        header("Location: ".$url);
    }
    else
        echo "Error: " . $insert . "<br>" . mysqli_error($sql);

    mysqli_close($sql);
}
else
    echo "Connection failed";


?>
