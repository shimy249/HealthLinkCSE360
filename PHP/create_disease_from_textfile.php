<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/3/2015
 * Time: 10:10 PM
 */

if ($type != 7){
    $_SESSION['notification'] = 'You do not have permission to access this page.';
    header("Location: index.php");
    return;
}

$dn = array();
$ds = array();
$de = array();

$aDisease = array();
$aSymptoms = array();
$aEmergency = array();


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
$fileName = 'DiseaseEmergency.txt';
$fileContent = file($fileName);
foreach($fileContent as $line) {
    array_push($de,$line );
}
for ($i = 0; $i < count($dn); ++$i) {
    echo $dn[$i]. ' '.$ds[$i]. ' '.$de[$i]. ' '.'<br>';
}
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if ($conn){
    for ($i = 0; $i < count($dn); ++$i) {
        $sql = "INSERT INTO DiseaseDefinitions (Name, SymptomList,Emergency) VALUES ('$dn[$i]', '$ds[$i]', '$de[$i]')";
        $conn->query($sql);
    }
}

?>