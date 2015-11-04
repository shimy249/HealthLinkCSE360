<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/8/2015
 * Time: 8:58 PM
 */
ob_start();
session_start();
$conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$step = 0;
if(isset($_POST['step'])) $step = $_POST['step'];
if ($step == 0) {
    header('Location: index.php');
    return;
}
else if ($step == 2) {

}
else if ($step == 2) {
    if ($_POST['selected_disease'] > 0){
        $diseaseID = $_POST['selected_disease'];
        $sql = "SELECT * FROM DiseaseDefinitions WHERE _id = '".$diseaseID."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($row['Emergency']== 1) $step = 4;
        else $step = 5;
    }
}

$symptom = $_POST['symptom'];
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION["userID"];


$notification = $_SESSION['notification'];
if(isset($_SESSION['notification'])){
    unset($_SESSION['notification']);
}
$ts = getdate();
$date = $ts[year].'-'.$ts[mon].'-'.$ts[mday];
$time = $ts[hours].':'.$ts[minutes].':'.$ts[seconds];


?>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Request Appointment</title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php
?>
<div class="main">
    <h1>IPMS - Home Page</h1>
    <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "homepage.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification ?></text>
    </div>

    <!-- Select Additional Symptoms [1]-->
    <div class = "subsection" style="margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;<?php if($step == 1) echo 'display:block;'; ?>">
        <center><h2>Select Additional Symptoms</h2></center>
        Choose option that most closely resembles your current health condition. If none of these options match your condition, select <q><i>None of these symptoms describe my condition</i></q>
        <form action="appointment_page.php" method = "post">
            <input type = "hidden" name = "step" value = "2">
            <?php
            $conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
            $sql = "SELECT * FROM DiseaseDefinitions WHERE SymptomList LIKE '%".$symptom."%'";
            $result = $conn->query($sql);
            if ($result->num_rows>0){
                while ($row = $result->fetch_assoc()){
                    echo '<input type = "radio" name = "selected_disease" value = "'.$row['_id'].'">';
                    echo '<text class = "p1">'.$row['SymptomList'].'</text><br>';
                }
            }
            ?>
            <input type = "radio" name = "selected_disease" value = "0"><text class = "o3">None of these symptoms describe my condition.</text>
            <center><input type="submit" class="submitButton" value="Submit"></center>
        </form>

    </div>

    <!-- Schedule General Doctor -->
    <div class = "subsection" style="margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;<?php if($step == 2) echo 'display:block;'; ?>">
        <center><h2>Schedule General Doctor</h2></center>
        <button class="showHideButton" onclick="showHide('ScheduleAppointment', this)">x</button>
        <div class="sectionContent" id="ScheduleAppointment">
            <form action="homepage.php?" method="post">
                <input type = "hidden" name = "step" value = "3">
                <div class="sectionLine">
                    Select a Doctor:
                    <select class="sectionLineInput" name="schedule_Doctor" >
                        <?php
                        $conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                        $sql = "SELECT * FROM UserData WHERE Type = 2";
                        $result = $conn->query($sql);
                        if($result->num_rows>0) {
                            while ($row = $result->fetch_assoc())
                                echo '<option value="' . $row['_id'] . '">' . $row["FirstName"] .' '. $row["LastName"]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="sectionLine">
                    Date:
                    <input type = "date" name="schedule_Date" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                </div>
                <center><input type="submit"  class="submitButton" value="View Available Appointments"></center>
            </form>
            <form action="schedule_appointments.php?" method="post" <?php if ($refreshApt) echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                <input type="hidden" name="schedule_Doctor" value = "<?php echo $_POST['schedule_Doctor'] ?>">
                <input type="hidden" name="schedule_Date" value = "<?php echo $_POST['schedule_Date'] ?>">
                <center><h3>Available Appointments</h3></center><br>
                <div class = "sectionLine">
                    <b><?php echo $schedule_DoctorName. ' on '.$_POST['schedule_Date']?></b><br>
                    <select name = "schedule_Time" class = "sectionLineInput">
                        <?php timeslot(7);timeslot(8);timeslot(9);timeslot(10);timeslot(11);timeslot(12);timeslot(13);timeslot(14);timeslot(15);timeslot(16);?>
                    </select>
                </div>
                <center><input type="submit"  class="submitButton" value="Create Appointment"></center>
            </form>
        </div>
    </div>


</div>
</form>
</div>
</body>
</html>