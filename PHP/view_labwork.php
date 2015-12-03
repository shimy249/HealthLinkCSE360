<?php
session_start();
ob_start();
date_default_timezone_set('America/Phoenix');
if (!isset($_SESSION['userID'])) {
    header('Location: index.php');
    return;
}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$labworkID = $_GET['labworkID'];
$notification = $_SESSION['notification'];

if (isset($_SESSION['notification'])) unset($_SESSION['notification']);
$resultText;
if(isset($_SESSION['resultText'])){
    $resultText = $_SESSION['resultText'];
    unset($_SESSION['resultText']);
}
if (isset($_SESSION['notification'])) unset($_SESSION['notification']);

$conn = mysqli_connect('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "SELECT * FROM Labwork WHERE _id = '" . $labworkID . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $_SESSION['notification'] = "This prescription does not exist.";
    header("Location: homepage.php");
}
$Labwork = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '" . $Labwork['PatientID'] . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $_SESSION['notification'] = "This prescription is invalid, please contact your doctor";
    header("Location: homepage.php");
}
$Patient = $result->fetch_assoc();

$sql = "SELECT * FROM UserData WHERE _id = '" . $Labwork['DoctorID'] . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $_SESSION['notification'] = "This prescription is invalid, please contact your doctor";
    header("Location: homepage.php");
}
$Doctor = $result->fetch_assoc();
?>

<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
    <title>IPIMS - View Labwork</title>
    <script type="text/javascript" src="main.js"></script>
    <script type="text/javascript">
        function getLabResult(){
            document.getElementById("DuplicateResultText1").value = document.getElementById("LabResultText").value;
            document.getElementById("DuplicateResultText2").value = document.getElementById("LabResultText").value;
            document.getElementById("DuplicateResultText3").value = document.getElementById("LabResultText").value;
        }
    </script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php

?>
<div class="main">
    <h1>IPIMS - View Labwork</h1>

    <div style="position:absolute;right:15px;top:10px;color:black;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 3BA3D0;">Home page</a> | <a href = "logout.php" style = "color: 3BA3D0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="o4"><b><?php echo $notification ?></b></text>
    </div>

        <form action="update_labwork.php?labworkID=<?php echo $labworkID; ?>" method="post" enctype="multipart/form-data" >
            <div class = "subsection" style="display: block; margin: 0 auto; width: 600px; top: 25px;padding-right:10px;padding-bottom: 10px;">
                <center><h2><?php echo $Labwork['Title']; ?></h2></center>
                <h3>Patient</h3> <?php echo $Patient['FirstName'] . ' ' . $Patient['LastName']; ?>
                <h3>Doctor</h3> <?php echo $Doctor['FirstName'] . ' ' . $Doctor['LastName']; ?>
                <h3>Date</h3> <?php echo $Labwork['Date']; ?>
                <h3>Description</h3> <?php echo $Labwork['Description']; ?>
                <h3>Results</h3>
                <div style="padding:10px; margin-bottom:10px; background-color: #E4E4E4;" >
                    <div>
                        <textarea id="LabResultText" style="width: 100%; height: 500px;" name="resultText" <?php if ($type != 3) echo 'readonly'; ?>><?php if ($resultText) echo $resultText; else echo $Labwork['Report']; ?></textarea>
                        <center><input type="submit"  name = "bSave" value="Save Entry" class="submitButton" <?php if ($type != 3) echo 'style="display:none;"'; ?> ></center>
                    </div>
                </div>
                <div style="background-color: #E4E4E4;<?php if ($type != 3) echo 'display:none'?>">
                    <div class="subsection" style="margin: 0 auto;display:block; background-color: #E4E4E4;">
                        <div>
                            <input type="hidden" id="DuplicateResultText1" name="report">
                            <h3>Add Attachment</h3>
                            <div class = "sectionLine">
                                File:
                                <div class = "sectionLineInput" style="width: 240px;">
                                    <input type="file" name="ufile"><br/>
                                </div>
                            </div>
                            <center><input type="submit"  name = "bAttach" value="Attach File" class="submitButton" ></center>

                        </div>
                        <div>
                            <h3>Attachments</h3>
                            <div class="overflow" style="max-height:500px;">
                                <?php
                                $sql = "SELECT * FROM LabAttachemnts WHERE labReportId='" . $labworkID . "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $file = $row["sysName"];
                                        $filepath = "/HealthLinkCSE360/PHP/uploads/" . basename($file);
                                        echo '<div class="appointmentBox">';
                                        if ($type == 3) echo '<input name = "files[]" type="checkbox" value="' . $row['_id'] . '" class = "selectBox">';
                                        echo '<a style = "color: #00B74A" href = "' . $filepath . '">' . $row['origName'] . '</a>';
                                        echo ' <text class = "o3">' . $row['uploadTime'] . '</text>';

                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>

                            <center><input type="submit"  name = "bRemove" value="Remove Selected Attachments" class="submitButton" ></center>
                        </div>
                    </div>
                </div>


                <?php
                $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                $sql = "SELECT * FROM Labwork WHERE _id='".$labworkID."'";
                $result = $conn->query($sql);
                $published = false;
                if ($result->num_rows>0){
                    $row = $result->fetch_assoc();
                    if ($row['Published'] == 1) $published = true;
                }
                ?>
                <div <?php if ($type != 3 || $published) echo 'style="display:none"'; ?>">
                <div <?php  if ($type != 3) echo 'style="display:none;'?>><input type="submit"  name = "bPublish" value="Save and Publish" class="submitButton" style="font-weight:bold;font-size:16px;"></div>
            </div>
            </div>
        </form>





</div>
</body>
</html>