<?php
/**
 * Created by PhpStorm.
 * User: Ashley
 * Date: 10/8/2015
 * Time: 8:58 PM
 */

$sql = mysqli_connect('localhost' , 'username' , 'password');

if($sql)
{
    echo "Connect successfully";

    if (isset($_POST['doctor']))
    {
        mysqli_select_db($sql, 'IPIMS');

        while(true) {

            if(isset($_POST["time and date" . $i] ) && !empty($_POST["time and date" . $i]))
            {
                $time = $_POST['time' . $i];
                $date = $_POST['date' . $i];
                $insert = "INSERT INTO appointments (time, date, doctor) Values ('$time', '$date', '$doctor')";
                $i++; 
            }
        }

    }
}

else
    echo 'Connect failed';

?>