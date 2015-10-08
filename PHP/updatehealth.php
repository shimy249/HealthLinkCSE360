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
    var $i = 0; 
    while(true)
    {
        

        if(isset($_POST["symptom".$i]) && !empty($_POST["symptom".$i])) {
            $symptoms = $_POST['symptoms'.$i];
            $severity = $_POST['severity'.$i];
            $additional = $_POST['additional'.$i];
            $insert = "INSERT INTO healthcondition (symptoms, severity, additional)
             VALUES ('$symptoms', '$severity', '$additional')";
             $i++;
        }
    }

}
else
    echo "Connection failed";
?>
