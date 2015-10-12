<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/11/15
 * Time: 9:03 AM
 */

ob_start();
$servername="localhost";
$username="appbfdlk";
$password="ohDAUdCL4AQZ0";
$database="appbfdlk_HealthLinkCSE360";

$conn = new mysqli($servername,$username, $password, $database);

$patientName = $_GET["user"];
$staffName = $_POST["Name"];
$startime = $_POST["starttime"];
$stime = DateTime::createFromFormat("m/d/Y, h:i A", $startime);
$stime=date("Y-m-d H:i:s",$stime);
$endtime = date("Y-m-dTh:m:00",strtotime("+30 minutes", $stime));

$pid;
$did;

$sql = "SELECT * FROM UserData WHERE UserName='".$patientName."'";
$result = $conn->query($sql);
if($result->num_rows>0) {
    while ($row = $result->fetch_assoc())
        $pid = $row["_id"];
}

$sql = "SELECT * FROM UserData WHERE Name='".$staffName."'";
$result = $conn->query($sql);
if($result->num_rows>0) {
    while ($row = $result->fetch_assoc())
        $did = $row["_id"];
}

$sql = "INSERT INTO Appointments(PatientID, StaffID, StartTime) VALUES ($pid,$did,$startime)";
$result=$conn->query($sql);
echo "error: ". mysqli_error($conn);
echo $sql;