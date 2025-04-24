<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "smart_streetlight";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>