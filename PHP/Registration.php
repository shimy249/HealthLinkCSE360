<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/5/2015
 * Time: 11:04 PM
 */

$sql = mysqli_connect('localhost','username', 'password');

if($sql)
{
    echo "Connect successfully";

    mysqli_select_db($sql,'IPIMS');

    $name = $_POST['patientname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $ssn = $_POST['ssn'];
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $answer1 = $_POST["answer1"];
    $answer2 = $_POST["answer2"];
    $answer3 = $_POST["answer3"];

    $insert = "INSERT INTO patients (patientname, dob, gender, ssn, phone, email, username, password, answer1, answer2, answer3)
    VALUES ('$name', '$dob', '$gender', '$ssn', '$phone', '$email', '$username', '$password', '$answer1', '$answer2', '$answer3')";


    if (mysqli_query($sql, $insert))
        echo "Registered Successfully";
    else
        echo "Error: " . $insert . "<br>" . mysqli_error($sql);

    mysqli_close($sql);
}
else
    echo "Connection failed";


?>
