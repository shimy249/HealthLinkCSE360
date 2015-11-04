<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 11/4/2015
 * Time: 12:53 AM
 */

session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
if (!isset($_SESSION['userID'])) {header('Location: index.php'); return;}
$user = $_SESSION["user"];
$type = $_SESSION["type"];
$userID = $_SESSION['userID'];
$notification = $_SESSION['notification'];
if(isset($_SESSION['notification'])){
    unset($_SESSION['notification']);
}
$diseaseID = $_SESSION['diseaseID'];

$refreshApt;
if(isset($_POST['schedule_Doctor']) && isset($_POST['schedule_Doctor'])) $refreshApt = true;
if(refreshApt){
    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "SELECT * FROM Vacations WHERE DoctorID = '".$_POST['schedule_Doctor']."'";
    $result=$conn->query($sql);
    if($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            $aDate = strtotime($_POST['schedule_Date']);
            $bStart = $row['StartDate'];
            $bStart = strtotime($bStart);
            $bEnd = $row['EndDate'];
            $bEnd = strtotime($bEnd);
            if ($aDate >= $bStart && $aDate <= $bEnd){
                $_SESSION['notification'] = "This doctor is on vacation from ".$row['StartDate']. " until ".$row['EndDate'].". Please change the date or schedule with a different doctor.";
                header('Location: appt_general.php');
                return;
            }
        }
    }
    $sql = "SELECT * FROM UserData WHERE _id = '".$_POST['schedule_Doctor']."'" ;
    $result=$conn->query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $schedule_DoctorName = $row['FirstName'].' '.$row['LastName'];
    }
}
function timeslot($aTime){
    $ts =  $GLOBALS['ts'];
    $date = $GLOBALS['date'];
    echo 'hello world';
    echo $ts['hours'].' '.$aTime;
    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
    $sql = "SELECT * FROM Appointments WHERE Date='".$_POST['schedule_Date']."'AND DoctorID = '".$_POST['schedule_Doctor'] ."' AND Hour = '".$aTime."'";
    $result=$conn->query($sql);
    if($result->num_rows == 0){
        if ($date == $_POST['schedule_Date'] && $aTime < $ts['hours']) return;
        echo '<option value="'.$aTime.'">'.$aTime.':00</option>';
    }
}
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

    <div class = "subsection" style="margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;display:block;">
        <center><h2>Schedule General Doctor</h2></center>
        <button class="showHideButton" onclick="showHide('ScheduleAppointment', this)">x</button>
        <div class="sectionContent" id="ScheduleAppointment">
            <form action="appt_general.php" method="post">
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
                    <input type = "date" required name="schedule_Date" min = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] + 1).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
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
