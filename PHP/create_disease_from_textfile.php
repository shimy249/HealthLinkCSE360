<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/3/2015
 * Time: 10:10 PM
 */
session_start();
ob_start();
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if ($_SESSION['type'] != 7){
    $_SESSION['notification'] = 'You do not have permission to access this page.';
    header("Location: index.php");
    return;
}

$dn = array();
$ds = array();
$de = array();
$as = array();

$aDisease = array();
$aSymptoms = array();
$aEmergency = array();


$fileName = 'DiseaseName.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    $line = trim($line);
    array_push($dn,$line );
}
$fileName = 'DiseaseSymptoms.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    $line = trim($line);
    array_push($ds,$line );
}
$fileName = 'DiseaseEmergency.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    $line = trim($line);
    array_push($de,$line );
}
$fileName = 'AllSymptoms.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    $line = trim($line);
    array_push($as,$line );
}
for ($i = 0; $i < count($dn); ++$i) {
    echo $dn[$i]. ' '.$ds[$i]. ' '.$de[$i]. ' '.'<br>';
}
if ($conn){

    for ($i = 0; $i < count($dn); ++$i) {
        $sql = "SELECT * FROM DiseaseDefinitions WHERE Name = '".$dn[$i]."'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO DiseaseDefinitions (Name, SymptomList,Emergency) VALUES ('$dn[$i]', '$ds[$i]', '$de[$i]')";
            $conn->query($sql);
        }
    }
    for ($i = 0; $i < count($as); ++$i) {
        $sql = "SELECT * FROM AllSymptoms WHERE Name = '".$as[$i]."'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO AllSymptoms (Name) VALUES ('$as[$i]')";
            $conn->query($sql);
        }
    }
}
header("Location: admin_home.php");

?>