<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/8/2015
 * Time: 1:41 PM
 */
$sql = mysqli_connect('localhost','username', 'password');
if($sql)
{
    mysqli_select_db($sql,'IPIMS');

    while(true)
    {
        $symptoms = $_POST['symptoms'];
        $severity = $_POST['severity'];
        $additional = $_POST['additional'];

        if(isset($_POST["value"]) && !empty($_POST["value"])) {
            $insert = "INSERT INTO healthcondition (symptoms, severity, additional)
             VALUES ('$symptoms', '$severity', '$additional')";
        }
    }

}
else
    echo "Connection failed";
?>
