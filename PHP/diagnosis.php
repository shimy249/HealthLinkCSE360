<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/8/2015
 * Time: 8:58 PM
 */
ob_start();
session_start();
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$aSymptoms = array();
$aSeverity = array();
$aDisease = array();
$aID = array();
if($conn) {
    $alert = 0;
    foreach ($_POST['symptom'] as $concern) {
        $sql = "SELECT * FROM Conditions WHERE _id='" . $concern."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row['Severity']>3) $alert=1;
                array_push($aSymptoms, trim($row['Symptom']));
                array_push($aSeverity, trim($row['Severity']));
            }
        }
    }


    //header('Location: homepage.php?notification=Your symptoms were submitted');
}

$dn = array();
$ds = array();

$fileName = 'DiseaseName.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    array_push($dn,$line );
}
$fileName = 'DiseaseSymptoms.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    array_push($ds,$line );
}

for ($i = 0; $i < count($dn); ++$i) {
    $match = true;
    foreach($aSymptoms as $iSymptom){
        if (!(strpos($ds[$i], $iSymptom) !== false))
            $match = false;
    }
    if($match == true) array_push($aDisease, $dn[$i]);
}

$symptoms = $aSymptoms[0].'('.$aSeverity[0].')';
for ($i = 1; $i < count($aSymptoms); ++$i) {
    $symptoms .= ', '.$aSymptoms[$i].'('.$aSeverity[$i].')';
}
$disease = '';
if (count($aDisease)>0) $disease = trim($aDisease[0]);
for ($i = 1; $i < count($aDisease); ++$i) {
    $disease = $disease.', '.trim($aDisease[$i]);
}
if($disease=='') $disease='[Inconclusive]';
echo $disease;
$sql = "INSERT INTO Diagnosis(PatientID,Symptoms,Date,Disease) VALUES ('$userID', '$symptoms', '$date', '$disease' )";
$conn->query($sql);

if ($alert>0){
    $sql = "INSERT INTO alerts (patient_name,summary) VALUES ('$user', '$symptoms')";
    $conn->query($sql);
}
header('Location: homepage.php?');
?>
