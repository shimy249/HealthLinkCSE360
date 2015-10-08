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
    if (isset($_POST['Submit']))
    {
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
    else if (isset($_POST['Get_diagnosis']))
         header('Location: /url/to/the/other/page');
    else if (isset($_POST['Appointment']))
        header('Location: /url/to/the/other/page');

}
else
    echo "Connection failed";
?>
