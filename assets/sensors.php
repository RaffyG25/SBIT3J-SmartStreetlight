<?php
require "dbconn.php";

$sql = "SELECT * FROM sensorvalues";
$result = $conn->query($sql);

$arduino = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arduino[] = $row;
    }
}

$conn->close();

return $arduino;

?>