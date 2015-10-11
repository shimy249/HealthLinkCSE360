<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Condition</title>
</head>
<body>

<div id="header">
    <center>
        <h1>Update Health Condition</h1></center>
</div>

<center>


</center>


    <center>
        <form action="updatehealth.php?user=<?php echo $_GET["user"]?>" method="post">
        Please Select a new condition:<br>
        <select name="condition">
            <option value="Cough"> Cough </option>
            <option value="Sore Throat"> Sore Throat </option>
        </select>

        <br><br>

        Please Enter the level of severity:<br>
            <input type="text" name="severity">
            <!--<input type="radio" name="severity" value="2">2
            <input type="radio" name="severity" value="3">3
            <input type="radio" name="severity" value="4">4
            <input type="radio" name="severity" value="5">5-->
            <br>
            <input type="submit">
        </form>
    </center>


</body>
</html>
