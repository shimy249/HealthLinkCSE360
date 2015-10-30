<?php
$conn = new mysqli('localhost', 'appbfdlk', 'ohDAUdCL4AQZ0', 'appbfdlk_HealthLinkCSE360');
$sql = "SELECT * FROM UserData WHERE _id='".$row["PatientID"]."'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc())
    echo '<option value="' . $row['_id'] . '">' . $row["FirstName"] .' '. $row["LastName"]. $row["doctor"]. $row["title"]. "</option>";

?>
