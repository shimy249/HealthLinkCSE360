<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>

<div id="header">
    <center>
        <h2>Interactive Patient Management System</h2><br>
        <h1>Homepage</h1>
    Welcome, <?php echo $_GET["user"]; ?>!<br>
    User Type:<?php echo $_GET["type"]; ?></center>
</div>

<form>
    <center>
        <input type="button" value="Manage Appointments" onclick="parent.location='manageappointments.php?<?php echo 'user='.$_GET["user"].'&type='.$_GET["type"]?>'"><br><br>
        <input type="button" value="Make an Appointment" onclick="parent.location='manageappointments.php?<?php echo 'user='.$_GET["user"].'&type='.$_GET["type"]?>'"><br><br>
        <input type="button" value="Update Health Conditions" onclick="parent.location='healthc.php?<?php echo 'user='.$_GET["user"].'&type='.$_GET["type"]?>'"><br><br>
        <input type="button" value="Send Alerts" onclick="parent.location='manageappointments.php?<?php echo 'user='.$_GET["user"].'&type='.$_GET["type"]?>'"><br><br>
        <input type="button" value="Logout" onclick="parent.location='../HTML JS/Login.html'">
    </center>
</form>

</body>
</html>
