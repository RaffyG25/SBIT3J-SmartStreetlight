<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "smart_streetlight";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

function fetchAccounts() {
    global $conn;
    $sql = "SELECT id_account, username, id_role FROM `account`";
    $result = $conn->query($sql);
    return $result;
}

function closeDatabaseConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
?>