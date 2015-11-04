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
    <title>IPMS - Home </title>
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
                        <input type="text" class="sectionLineInput" name="profile_FirstName" >
                    </div>
                    <div class="sectionLine">
                        Last Name:
                        <input type="text" class="sectionLineInput" name="profile_LastName">
                    </div>
                    <div class="sectionLine">
                        Email Address:
                        <input type="text" class="sectionLineInput" name="profile_Email">
                    </div>
                    <div class="sectionLine">
                        Username:
                        <input type="text" class="sectionLineInput" name="profile_Username">
                    </div>
                    <div class="sectionLine">
                        Password:
                        <input type="text" class="sectionLineInput" name="profile_Password" >
                    </div>
                    <div class="sectionLine">
                        Date Of Birth:
                        <input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $ts[year].'-'.$ts[mon].'-'.$ts[mday];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                    </div>
                    <div class="sectionLine">
                        Social Security Number:
                        <input type="text" class="sectionLineInput" name="profile_SocialSecurity">
                    </div>
                    <div class="sectionLine">
                        Gender:
                        <select class="sectionLineInput" name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
                    </div>
                    <div class="sectionLine">
                        Street Address:
                        <input type="text" class="sectionLineInput" name="profile_Address">
                    </div>
                    <div class="sectionLine">
                        City:
                        <input type="text" class="sectionLineInput" name="profile_City">
                    </div>
                    <div class="sectionLine">
                        State:
                        <select name="profile_State" class="sectionLineInput">	<option value="AL">AL</option>	<option value = '' checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
                    </div>
                    <div class="sectionLine">
                        Zip:
                        <input type="text" class="sectionLineInput" name="profile_Zip">
                    </div>
                    <div class="sectionLine">
                        Phone:
                        <input type="text" class="sectionLineInput" name="profile_Phone">
                    </div>
                    <div class="sectionLine">
                        Security Question 1:
                        <input type="text" class="sectionLineInput" name="profile_Question1" >
                    </div>
                    <div class="sectionLine">
                        Security Answer 1:
                        <input type="text" class="sectionLineInput" name="profile_Answer1" >
                    </div>
                    <div class="sectionLine">
                        Security Question 2:
                        <input type="text" class="sectionLineInput" name="profile_Question2" >
                    </div>
                    <div class="sectionLine">
                        Security Answer 2:
                        <input type="text" class="sectionLineInput" name="profile_Answer2" >
                    </div>
                    <div class="sectionLine">
                        Security Question 3:
                        <input type="text" class="sectionLineInput" name="profile_Question3" >
                    </div>
                    <div class="sectionLine">
                        Security Answer 3:
                        <input type="text" class="sectionLineInput" name="profile_Answer3" >
                    </div>
                    <div class="sectionLine">
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
                            <input type="text" class="sectionLineInput" name="profile_FirstName" value = "<?php echo $userRow['FirstName'];?>">
                        </div>
                        <div class="sectionLine">
                            Last Name:
                            <input type="text" class="sectionLineInput" name="profile_LastName" value = "<?php echo $userRow['LastName'];?>">
                        </div>
                        <div class="sectionLine">
                            Email Address:
                            <input type="text" class="sectionLineInput" name="profile_Email" value = "<?php echo $userRow['Email'];?>">
                        </div>
                        <div class="sectionLine">
                            Username:
                            <input type="text" class="sectionLineInput" name="profile_Username" value = "<?php echo $userRow['UserName'];?>">
                        </div>
                        <div class="sectionLine">
                            Password:
                            <input type="text" class="sectionLineInput" name="profile_Password" value = "<?php echo $userRow['Password'];?>" >
                        </div>
                        <div class="sectionLine">
                            Date Of Birth:
                            <input type = "date" name="profile_DateOfBirth" min = "<?php echo ($ts[year] - 100).'-'.$ts[mon].'-'.$ts[mday];?>" value = "<?php echo $userRow['DOB'];?>" max = "<?php echo ($ts[year] -18).'-'.$ts[mon].'-'.$ts[mday];?>" class = "sectionLineInput">
                        </div>
                        <div class="sectionLine">
                            Social Security Number:
                            <input type="text" class="sectionLineInput" name="profile_SocialSecurity" value = "<?php echo $userRow['SSN'];?>">
                        </div>
                        <div class="sectionLine">
                            Gender:
                            <select class="sectionLineInput" name="profile_Gender"><option value = "M">Male</option><option value = "F">Female</option></select>
                        </div>
                        <div class="sectionLine">
                            Street Address:
                            <input type="text" class="sectionLineInput" name="profile_Address" value = "<?php echo $userRow['Address'];?>">
                        </div>
                        <div class="sectionLine">
                            City:
                            <input type="text" class="sectionLineInput" name="profile_City" value = "<?php echo $userRow['City'];?>">
                        </div>
                        <div class="sectionLine">
                            State:
                            <select name="profile_State" class="sectionLineInput">	<option value="AL">AL</option>	<option value = "" checked = 1>--Select--</option><option value="AK">AK</option>	<option value="AZ">AZ</option>	<option value="AR">AR</option>	<option value="CA">CA</option>	<option value="CO">CO</option>	<option value="CT">CT</option>	<option value="DE">DE</option>	<option value="DC">DC</option>	<option value="FL">FL</option>	<option value="GA">GA</option>	<option value="HI">HI</option>	<option value="ID">ID</option>	<option value="IL">IL</option>	<option value="IN">IN</option>	<option value="IA">IA</option>	<option value="KS">KS</option>	<option value="KY">KY</option>	<option value="LA">LA</option>	<option value="ME">ME</option>	<option value="MD">MD</option>	<option value="MA">MA</option>	<option value="MI">MI</option>	<option value="MN">MN</option>	<option value="MS">MS</option>	<option value="MO">MO</option>	<option value="MT">MT</option>	<option value="NE">NE</option>	<option value="NV">NV</option>	<option value="NH">NH</option>	<option value="NJ">NJ</option>	<option value="NM">NM</option>	<option value="NY">NY</option>	<option value="NC">NC</option>	<option value="ND">ND</option>	<option value="OH">OH</option>	<option value="OK">OK</option>	<option value="OR">OR</option>	<option value="PA">PA</option>	<option value="RI">RI</option>	<option value="SC">SC</option>	<option value="SD">SD</option>	<option value="TN">TN</option>	<option value="TX">TX</option>	<option value="UT">UT</option>	<option value="VT">VT</option>	<option value="VA">VA</option>	<option value="WA">WA</option>	<option value="WV">WV</option>	<option value="WI">WI</option>	<option value="WY">WY</option></select>
                        </div>
                        <div class="sectionLine">
                            Zip:
                            <input type="text" class="sectionLineInput" name="profile_Zip" value = "<?php echo $userRow['Zip'];?>">
                        </div>
                        <div class="sectionLine">
                            Phone:
                            <input type="text" class="sectionLineInput" name="profile_Phone" value = "<?php echo $userRow['Phone'];?>">
                        </div>
                        <div class="sectionLine">
                            Security Question 1:
                            <input type="text" class="sectionLineInput" name="profile_Question1" value = "<?php echo $userRow['q1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 1:
                            <input type="text" class="sectionLineInput" name="profile_Answer1" value = "<?php echo $userRow['a1'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 2:
                            <input type="text" class="sectionLineInput" name="profile_Question2" value = "<?php echo $userRow['q2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 2:
                            <input type="text" class="sectionLineInput" name="profile_Answer2" value = "<?php echo $userRow['a2'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Question 3:
                            <input type="text" class="sectionLineInput" name="profile_Question3" value = "<?php echo $userRow['q3'];?>" >
                        </div>
                        <div class="sectionLine">
                            Security Answer 3:
                            <input type="text" class="sectionLineInput" name="profile_Answer3"  value = "<?php echo $userRow['a3'];?>">
                        </div>
                        <div class ="sectionLine">
                            <select name = "profile_Type" class = "sectionLineInput">
                                <option value = '1'>Patient</option>
                                <option value = '2'>General Doctor</option>
                                <option value = '3'>Lab Technician</option>
                                <option value = '4'>Staff</option>
                                <option value = '5'>Nurse</option>
                                <option value = '6'>Emergency Doctor</option>
                                <option value = '7'>Admin</option>
                            </select>
                        </div>
                        <center><input type="submit"  class="submitButton" value="Update Information" action=""></center>
                    </form>
                </div>



            </div>
        </div>

    </div>


    <div class="column" style='left:420px; top: 80px;'>

    </div>
</div>
</body>
</html>
