<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/8/2015
 * Time: 1:41 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];

$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

$condition = $_POST["Symptom"];
$severity=$_POST["Severity"];
$notes = $_POST['Notes'];
$date= date("Y-m-d");
$content = $condition . "; " . $severity ."; ".$notes;

$sql = "SELECT * FROM UserData WHERE UserName='".$user."'";
$result=$conn->query($sql);
$userID;

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $userID = $row["_id"];
    }
}

$sql = "INSERT INTO MedicalRecords(DateEntered, Type, Content, UserId) VALUES ('$date', 'Condition', '$content', '$userID')";
if($conn->query($sql)){
    echo "added";
    $_SESSION['notification'] = "Your symptoms were submitted";
    header('Location: homepage.php');
}




/*if($sql)
{
    if (isset($_POST['Submit']))
    {
        mysqli_select_db($sql,'IPIMS');
        $i = 0;
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
*/
?>
