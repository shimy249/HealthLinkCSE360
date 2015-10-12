<?php
/**
 * Created by PhpStorm.
 * User: masta
 * Date: 10/8/2015
 * Time: 1:41 PM
 */
ob_start();
$conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

$user = $_GET["user"];
$condition = $_POST["Symptom"];
$severity=$_POST["Severity"];
$date= date("Y-m-d");
$content = $condition . "; " . $severity;

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
    header('Location: homepage.php?user='.$user);
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
