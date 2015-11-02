<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/10/15
 * Time: 11:06 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
$_SESSION['notification'] = '';
$servername = "localhost";
$username = "appbfdlk";
$password = "ohDAUdCL4AQZ0";
$database = "appbfdlk_HealthLinkCSE360";

$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM UserData WHERE UserName='" . $_POST["login_Username"]."'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if ($row["Password"] != $_POST["login_Password"]){
        $_SESSION['notification'] = "Incorrect Username/Password combination";
        echo "index";
        header("Location: index.php");
        exit;
    }

    echo $row["Password"].' '.$_POST['login_Password'];
    $_SESSION["type"] = $row["Type"];
    $_SESSION["user"] = $row["UserName"];
    $_SESSION["userID"] = $row["_id"];
    $url = "homepage.php";
    echo $_SESSION["user"];
    $_SESSION['notification'] = "Welcome ".$row['FirstName'];
    header("Location: ".$url);
    return;
} else {
    $_SESSION['notification'] = "This Username does not exist";
    header("Location: index.php");
    return;
}

?>
