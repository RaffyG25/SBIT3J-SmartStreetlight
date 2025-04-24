<?php
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "smart_streetlight";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

