<?php
session_start();
require 'dbconn.php';

function validate($inputData){

    global $conn;

    return mysqli_real_escape_string($conn, $inputData);
}

function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '.$url);
    exit(0);
}

?>