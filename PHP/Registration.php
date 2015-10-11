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

    $name = $_POST['patientname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $ssn = $_POST['ssn'];
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $address = $_POST["Address"];

    $format="%d/%m/%y";
    $dob=strptime(dob, $format);
    $dob=date("Y-m-d", $dob);

    $insert = "INSERT INTO UserData (Name, DOB, Gender, SSN, Phone, Email, UserName,Password,Address)
    VALUES ('$name', '$dob', '$gender', '$ssn', '$phone', '$email', '$username', '$password','$address')";


    if (mysqli_query($sql, $insert))
        echo "Registered Successfully";
    else
        echo "Error: " . $insert . "<br>" . mysqli_error($sql);

    mysqli_close($sql);
}
else
    echo "Connection failed";


?>
