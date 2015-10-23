<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/8/2015
 * Time: 8:58 PM
 */
ob_start();
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$patient = $_GET["user"];
$summary = "";
if($conn) {
    $alert = 0;
    foreach ($_POST['symptom'] as $symptom) {
        $sql = "SELECT * FROM MedicalRecords WHERE _id='" . $symptom."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $content=$row["Content"];
                list($currentCond, $currentSever) = explode("; ", $content);
                if($currentSever>3){
                    $alert=1;
                    break;
                }
            }
        }
    }
    if ($alert>0){

        foreach ($_POST['symptom'] as $symptom) {
            $sql = "SELECT * FROM MedicalRecords WHERE _id='" . $symptom."'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $content=$row["Content"];
                    list($currentCond, $currentSever) = explode("; ", $content);
                    $summary = $summary.$currentCond." (".$currentSever.") ";
                }
            }
        }
        echo $patient;
        echo $summary;
        $sql = "INSERT INTO alerts (patient_name,summary) VALUES ('$patient', '$summary')";
        $conn->query($sql);

    }

    header('Location: homepage.php?user='.$patient.'&notification=Your symptoms were submitted');
}

else
    echo 'Connect failed';

?>
