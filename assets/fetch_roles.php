<?php
require 'connection.php';

$sql = "SELECT id_role, value FROM roles";
$result = $conn->query($sql);

$roles = array();
if ($result->num_rows > 0) {
    // Fetch all roles as an associative array
    while($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Return the roles as JSON
header('Content-Type: application/json');
echo json_encode($roles);
$conn->close();
?>