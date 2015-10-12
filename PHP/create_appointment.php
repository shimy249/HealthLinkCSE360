<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Appointment</title>
</head>
<body>
<form action="add_apt.php?user=<?php echo $_GET["user"] ?>" method="post">
    Doctor: <select name="staff_name">
        <?php
        $conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
        $sql = "SELECT * FROM UserData WHERE type='Doctor'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc())
                echo "<option value=".$row['Name']."'>".$row["Name"]."</option>";

        }
        ?>

    </select>
    <br/>
    Time: <input type="datetime-local" name="starttime">
    <br/>
    <input type="submit">
</form>
</body>
</html>