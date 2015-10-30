<?php
session_start();
$notification = $_SESSION['notification'];
$_SESSION['notification'] = '';
$email = $_POST['email'];

$conn = mysqli_connect('localhost' , 'appbfdlk' , 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "SELECT * FROM UserData WHERE Email='".$email."'";
$result=$conn->query($sql);
$userRow;
if ($result->num_rows==1){
    $userRow = $result->fetch_assoc();
}
else {
    $_SESSION['notification'] = 'There are no accounts registered to this email';
    header("Location: index.php");
    return;
}
?>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Interactive Patient Management System</title>
    <script type="text/javascript" src="main.js">


    </script>
    <link rel="stylesheet" type="text/css" href="style.css">
    </style></head>
<body onload="setTimeout(hideNotifications, 5000)">
<div class="main">
    <center><h1>Interactive Patient Management System</h1></center>
    <div id="notifications" style="width:100%;text-align:center;">
        <text class="b4"><?php echo $notification; ?></text>
    </div>
    <div class="column" style='left:220px; top: 80px;'>

        <div class="subsection" style="display:block;">
            <form action="alt_login.php" method="post">
                <input type = "hidden" name="userID" value="<?php echo $userRow['_id']?>">
                <center><h2>Identity Verification</h2></center>
                <?php echo $userRow['q1'] ?>
                <input name = "a1" type="password" style="width:100%;"><br><br>
                <?php echo $userRow['q2'] ?>
                <input name = "a2" type="password" style="width:100%;"><br><br>
                <?php echo $userRow['q3'] ?>
                <input name = "a3" type="password" style="width:100%;"><br><br>
                <input type = "submit" class = "submitButton" value = "Log in">
            </form>
        </div>

    </div>
</div>

</body>
</html>