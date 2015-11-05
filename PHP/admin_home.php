<?php
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
$modifyID;
if (isset($_POST['modify_id'])) $modifyID = $_POST['modify_id'];

?>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>IPMS - Admin Home </title>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<?php
?>
<div class="main">
    <h1>Admin Home Page</h1>
    <div style="position:absolute;right:15px;top:10px;color:white;text-align:right;">
        Logged in as <text class="o4"><b><?php echo $user; ?></b></text><br>
        <a href = "admin_home.php" style = "color: 63AFD0;">Home page</a> | <a href = "logout.php" style = "color: 63AFD0;">Log out</a>
    </div>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification ?></text>
    </div>

    <!-- Left Column -->
    <div class="column" style='left:10px; top: 80px;'>

        <!-- Create New User -->
        <div class="subsection" style="display:block;">
            <center><h2>Create New User</h2></center>
            <button class="showHideButton" onclick="showHide('PersonalInformation', this)">x</button>
            <div class="sectionContent" id="PersonalInformation">
                <div class = "overflow">
                    <form action="Registration.php" method="post">
                        <input type="hidden" name = "admin" value="true">
                        <div class="sectionLine">
                            First Name:
                            <input type="text" class="sectionLineInput" required name="profile_FirstName" >
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" required name="profile_LastName">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" required name="profile_Email">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" required name="profile_Username">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" required name="profile_Password" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth:
                            <input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" required name="profile_SocialSecurity">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <select class="sectionLineInput" required name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
                        </div>
                        <div class="sectionLine">
                            Street Address:
                            <input type="text" class="sectionLineInput" required name="profile_Address">
                        </div>
                        <div class="sectionLine">
                            City:
                            <input type="text" class="sectionLineInput" required name="profile_City">
                        </div>
                        <div class="sectionLine">
                            State:
                            <select name="profile_State" class="sectionLineInput" required>	<option value="AL">AL</option>	<option value = '' checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
                        </div>
                        <div class="sectionLine">
                            Zip:
                            <input type="text" class="sectionLineInput" required name="profile_Zip">
                        </div>
                        <div class="sectionLine">
                            Phone:
                            <input type="text" class="sectionLineInput" required name="profile_Phone">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" required name="profile_Question1" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" required name="profile_Answer1" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" required name="profile_Question2" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" required name="profile_Answer2" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" required name="profile_Question3" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" required name="profile_Answer3" >
                        </div>
                        <div class="sectionLine">
                            User Role:
                            <select name = "profile_Type" class = "sectionLineInput">
                                <option value = '1'>Patient</option>
                                <option value = '2'>Doctor</option>
                                <option value = '3'>Lab Technician</option>
                                <option value = '4'>Staff</option>
                                <option value = '5'>Nurse</option>
                                <option value = '6'>Emergency Doctor</option>
                                <option value = '7'>Admin</option>
                            </select>
                        </div>


                        <center><input type="submit"  class="submitButton" value="Register Now"></center>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modify User -->
        <div class="subsection" style="display:block;">
            <center><h2>Modify User</h2></center>
            <button class="showHideButton" onclick="showHide('PersonalInformation', this)">x</button>
            <div class="sectionContent" id="PersonalInformation" >
                <form action = "admin_home.php" method = "post">
                    <div class="sectionLine">
                        Select a User:
                        <select name="modify_id" class = "sectionLineInput">
                            <option value = "">--Select--</option>
                            <?php
                            $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                            $sql = "SELECT * FROM UserData ORDER BY FirstName ASC";
                            $result=$conn->query($sql);
                            while ($row= $result->fetch_assoc()){
                                echo '<option value = "'.$row['_id'].'">'.$row['FirstName'].' '.$row['LastName'].'</option>';
                            }

                            ?>
                        </select>
                        <center><input type="submit"  class="submitButton" value="Edit This User" ></center>
                    </div>
                </form>
                <br>
                <?php
                if ($modifyID){
                    $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM UserData WHERE _id='".$modifyID."'";
                    $result=$conn->query($sql);
                    $userRow = $result->fetch_assoc();
                }
                if ($modifyID) echo '<h3>'.$userRow['FirstName'].' '.$userRow['LastName'].'</h3><br>'
                ?>
                <div class = "overflow"  <?php if (!$modifyID) echo 'style = "display:none"';?>>
                    <form action="update_profile.php" method="post" >

                        <input type = "hidden" name = "modify_id" value = "<?php if ($modifyID) echo $modifyID;?>">

                        <div class="sectionLine">
                            First Name:
                            <input type="text" class="sectionLineInput" required name="profile_FirstName" value = "<?php echo $userRow['FirstName'];?>">
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" required name="profile_LastName" value = "<?php echo $userRow['LastName'];?>">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" required name="profile_Email" value = "<?php echo $userRow['Email'];?>">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" required name="profile_Username" value = "<?php echo $userRow['UserName'];?>">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" required name="profile_Password" value = "<?php echo $userRow['Password'];?>" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth:
                            <input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $userRow['DOB'];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" required name="profile_SocialSecurity" value = "<?php echo $userRow['SSN'];?>">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <select class="sectionLineInput" required name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
                        </div>
                        <div class="sectionLine">
                            Street Address:
                            <input type="text" class="sectionLineInput" required name="profile_Address" value = "<?php echo $userRow['Address'];?>">
                        </div>
                        <div class="sectionLine">
                            City:
                            <input type="text" class="sectionLineInput" required name="profile_City" value = "<?php echo $userRow['City'];?>">
                        </div>
                        <div class="sectionLine">
                            State:
                            <select name="profile_State" class="sectionLineInput" required>	<option value="AL">AL</option>	<option value = "" checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
                        </div>
                        <div class="sectionLine">
                            Zip:
                            <input type="text" class="sectionLineInput" required name="profile_Zip" value = "<?php echo $userRow['Zip'];?>">
                        </div>
                        <div class="sectionLine">
                            Phone:
                            <input type="text" class="sectionLineInput" required name="profile_Phone" value = "<?php echo $userRow['Phone'];?>">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" required name="profile_Question1" value = "<?php echo $userRow['q1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" required name="profile_Answer1" value = "<?php echo $userRow['a1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" required name="profile_Question2" value = "<?php echo $userRow['q2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" required name="profile_Answer2" value = "<?php echo $userRow['a2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" required name="profile_Question3" value = "<?php echo $userRow['q3'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" required name="profile_Answer3"  value = "<?php echo $userRow['a3'];?>">
                        </div>
                        <div class ="sectionLine" <?php if ($userRow['Type']==7) echo 'style="display:none;"'?>>
                            User Role:
                            <select name = "profile_Type" class = "sectionLineInput">
                                <option value = '1' <?php if ($userRow['Type']==1) echo 'selected'?>>Patient</option>
                                <option value = '2' <?php if ($userRow['Type']==2) echo 'selected'?>>General Doctor</option>
                                <option value = '3' <?php if ($userRow['Type']==3) echo 'selected'?>>Lab Technician</option>
                                <option value = '4' <?php if ($userRow['Type']==4) echo 'selected'?>>Staff</option>
                                <option value = '5' <?php if ($userRow['Type']==5) echo 'selected'?>>Nurse</option>
                                <option value = '6' <?php if ($userRow['Type']==6) echo 'selected'?>>Emergency Doctor</option>
                                <option value = '7' <?php if ($userRow['Type']==7) echo 'selected'?>>Admin</option>
                            </select>
                        </div>
                        <center><input type="submit"  class="submitButton" value="Update Information" action=""></center>
                    </form>
                </div>
            </div>
        </div>
        <!-- Statistical Report -->
        <div class = "subsection" <?php if ($type == 7) echo 'style="display:block;"'; ?>>
            <center><h2>Statistical Report</h2></center>
            <button class="showHideButton" onclick="showHide('StatInfo', this)">x</button>
            <div class="sectionContent" id="StatInfo" style="display: block; max-height:none;">
                <?php


                $conn = mysqli_connect('localhost','appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');

                $sql = "SELECT * FROM UserData WHERE Type=1";
                $res = $conn->query($sql);
                $patientCount = $res->num_rows;

                $sql = "SELECT * FROM UserData WHERE Type=1&&Gender LIKE 'm'";
                $res = $conn->query($sql);
                $male = $res->num_rows;

                $sql = "SELECT * FROM UserData WHERE Type=1&&Gender LIKE 'f'";
                $res = $conn->query($sql);
                $female = $res->num_rows;


                $sql = "SELECT * FROM UserData WHERE Type=2";
                $res = $conn->query($sql);
                $docCount = $res->num_rows;

                $sql = "SELECT * FROM UserData WHERE Type=3";
                $res = $conn->query($sql);
                $staffCount = $res->num_rows;

                $sql = "SELECT * FROM Appointments WHERE Date>=CURRENT_DATE";
                $res = $conn->query($sql);
                $aptCount = $res->num_rows;

                $sql = "SELECT * FROM MedicalRecords";
                $res = $conn->query($sql);
                $recordCount = $res->num_rows;

                $sql = "SELECT * FROM Conditions";
                $res = $conn->query($sql);
                $diagCount = $res->num_rows;

                $sql = "SELECT * FROM Labwork WHERE Report IS NOT NULL";
                $res = $conn->query($sql);
                $labReport = $res->num_rows;

                $sql = "SELECT * FROM Prescriptions";
                $res = $conn->query($sql);
                $prescriptions = $res->num_rows;


                ?>
                <h3>Number of Patients</h3> <?php echo $patientCount. "   (". $male. " male ". $female." female)";?>
                <h3>Number of Doctors</h3> <?php echo $docCount;?>
                <h3>Number of Other Medical Staff</h3> <?php echo $staffCount;?>
                <h3>Number of Future Appointments</h3> <?php echo $aptCount;?>
                <h3>Number of Medical Record Entries</h3> <?php echo $recordCount;?>
                <h3>Number of Diagnosis Issued</h3> <?php echo $diagCount;?>
                <h3>Number of Lab Reports Created</h3> <?php echo $labReport;?>
                <h3>Number of Prescriptions Issued</h3> <?php echo $prescriptions;?>
            </div>

        </div>

    </div>


    <div class="column" style='left:420px; top: 80px;'>
        <!-- Define Symptom -->
        <div class = "subsection" <?php if ($type == 7) echo 'style="display:block;"'; ?>>
            <center><h2>Define Symptom</h2></center>
            <button class="showHideButton" onclick="showHide('CreateSymptom', this)">x</button>
            <div class="sectionContent" id="StatInfo" style="display: block; max-height:none;">
                <form action = "define_symptom.php" method = "post">
                    End users can only select symptoms from a predefined list. You can add define a new symptom below<br>
                    <div class = "sectionLine">
                        Symptom:
                        <input type="text" class="sectionLineInput" required name="symptom"  >
                    </div>
                    <center><input type="submit"  class="submitButton" value="Add this Symptom" action=""></center>
                </form>

            </div>
        </div>

        <!-- Define Disease -->
        <div class = "subsection" <?php if ($type == 7) echo 'style="display:block;"'; ?>>
            <center><h2>Define Disease</h2></center>
            <button class="showHideButton" onclick="showHide('DefineDisease', this)">x</button>
            <div class="sectionContent" id="DefineDisease" style="display: block; max-height:none;">
                <form action = "define_disease.php" method = "post">
                    When users schedule appointments, they select a primary symptom which is matched to known diseases. You can add a new disease by defining its symptoms and whether or not it should trigger an emergency.<br><br>
                    <div class = "sectionLine">
                        Disease Name:
                        <input type="text" class="sectionLineInput" required name="name" style="width:252px"  >
                    </div>
                    <div class = "sectionLine">
                        Add this Symptom:
                        <div class = "sectionLineInput" style="width:250px">
                            <select id = "ChosenSymptom" style="width:142px">
                                <option></option>
                                <?php
                                $conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                                $sql = "SELECT * FROM AllSymptoms ORDER BY Name";
                                $result = $conn->query($sql);
                                if ($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()){
                                        echo '<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <input type="button" onclick = "addSymptom();" style="width:50px" value = "Add">
                            <input type="button" onclick = "clearSymptoms();" style="width:50px" value = "Clear">
                        </div>
                    </div>
                    <textarea id = "SymptomList" readonly style="margin-bottom: 10px;" name = "symptoms"></textarea>
                    <div class = "sectionLine">
                        Trigger Emergency?:
                        <select class="sectionLineInput" name="emergency" >
                            <option value = "0">No</option>
                            <option value = "1">Yes</option>
                        </select>
                    </div>
                    <center><input type="submit"  class="submitButton" value="Add this Disease" action=""></center>
                </form>
                <form action="create_disease_from_textfile.php">
                    <br>You can also import the default disease definitions by clicking below:
                    <center><input type="submit"  class="submitButton" value="Import Default Definitions" action=""></center>
                </form>
                </div>
            </div>

        <!--  Disease Definitions-->
        <div class = "subsection" <?php if ($type == 7) echo 'style="display:block;"'; ?>>
            <center><h2>Disease Definitions</h2></center>
            <button class="showHideButton" onclick="showHide('DiseaseDefinitions', this)">x</button>
            <div class="sectionContent" id="DiseaseDefinitions" style="display: block; max-height:none;">

                    <form action = "delete_disease.php" method = "post">
                    <div class = "overflow" style="max-height:500px;">
                    <?php
                    $conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
                    $sql = "SELECT * FROM DiseaseDefinitions ORDER BY Name";
                    $result = $conn->query($sql);
                    if ($result->num_rows>0){
                        while ($row = $result->fetch_assoc()){
                            echo "<div class='appointmentBox'>";
                            echo '<input name="disease[]" type="checkbox" value="'. $row["_id"].'" class = "selectBox">';
                            echo ' Name: <text class="p1">'.$row['Name'].'</text>' ;
                            echo ' Emergency?: ';
                            if ($row['Emergency'] == 1) echo '<text class="o3">Yes</text>';
                            else echo '<text class="o3">No</text>';
                            echo '<br>Symptoms: <text class="b2">'.$row['SymptomList'].'</text>';
                            echo '</div>';
                        }
                    }
                    ?>
                    </div>
                    <center><input type = "submit" class = "submitButton" value = "Delete Selected"></center>';
                </form>

            </div>
        </div>
    </div>


</div>



        </div>

    </div>
</div>
</div>
</body>
</html>
