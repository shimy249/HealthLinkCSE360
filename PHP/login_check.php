<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/10/15
 * Time: 11:06 PM
 */
session_start();
ob_start();
$servername = "localhost";
$username = "appbfdlk";
$password = "ohDAUdCL4AQZ0";
$database = "appbfdlk_HealthLinkCSE360";

$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM UserData WHERE UserName='" . $_POST["profile_Username"]."'";

$result = $conn->query($sql);
echo $result->num_rows;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $_SESSION["type"] = $row["Type"];
        $_SESSION["user"] = $row["UserName"];
    }
    $url = "homepage.php";
    echo $_SESSION["user"];
    header("Location: ".$url);
} else{
    $url = "../HTML JS/Login.html";
    echo $_POST["username"];
    echo $_POST["type"];
    echo $sql;
    //header("Location: ". $url);

}

?>
