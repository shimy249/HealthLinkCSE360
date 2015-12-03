<?php
ob_start();
session_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
date_default_timezone_set ('America/Phoenix');
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
if($conn) {
    foreach ($_POST['files'] as $file) {
        $sql = "DELETE FROM UploadFiles WHERE _id='" . $file."'";
        $result = $conn->query($sql);
    }
    header("Location: " . $_POST['source']);
}
?>