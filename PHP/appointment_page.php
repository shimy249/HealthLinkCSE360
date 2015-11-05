<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/8/2015
 * Time: 8:58 PM
 */
ob_start();
session_start();
date_default_timezone_set ('America/Phoenix');
$conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

$symptom;
$diseaseID ;
if(isset($_POST['symptom'])){
    $symptom = trim($_POST['symptom']);
}

if(isset($_SESSION['diseaseID'])){
    $diseaseID = $_SESSION['diseaseID'];
    $form = 2;
}

echo $symptom;
echo 'hello';
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
$now = time();
$thirty_minutes = $now + (30*60);
$three_days = $now + (3*24*60*60)

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
    <div class = "subsection" style="margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;<?php if($symptom) echo 'display:block;'; ?>">
        <center><h2>Select Additional Symptoms</h2></center>
        Choose option that most closely resembles your current health condition. If none of these options match your condition, select <q><i>None of these symptoms describe my condition</i></q>
        <form action="appt_route.php" method = "post">
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
    <div class = "subsection" style="margin: 0 auto; width: 400px; top: 25px;padding-right:10px;padding-bottom: 10px;<?php if($form == 2) echo 'display:block;'; ?>">
        <center><h2>Schedule Emergency Appointment</h2></center>
        <?php
        $sql = "SELECT * FROM DiseaseDefinitions WHERE _id = '".$diseaseID."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <form action="schedule_emergency.php" method = "post">
            The symptoms you selected match the known symptoms for the condition: <?php echo $row['Name']?>.
            We suggest that you schedule an appointment with our emergency ward.
            However, if you would prefer you may also schedule a general doctor appointment by clicking <a href = "appt_general.php?diseaseID=<?php echo $diseaseID?>">here</a>.
            Please fill out the information below to schedule an emergency appointment:<br><br>
            <div class = "sectionLine">
                Estimated Time of Arrival:
                <input name = "datetime" type = "datetime-local" style = "width: 250px;" min = "<?php echo date("Y-m-d\TH:i:s",$now) ?>" value = "<?php echo date("Y-m-d\TH:i:s",$thirty_minutes) ?>" max = "<?php echo date("Y-m-d\TH:i:s",$three_days) ?>" class = "sectionLineInput">
            </div>
            <center><input type="submit" class="submitButton" value="Schedule Emergency Appointment"></center>
            </div>
        </form>

    </div>


</div>
</form>
</div>
</body>
</html>