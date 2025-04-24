<?php
session_start();
require 'function.php';

if(isset($_POST['insert_user'])){
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $role = validate($_POST['role']);

    $hashpass = password_hash($password, PASSWORD_DEFAULT);

    if ($username != '' || $password != ''){
        $query = "INSERT INTO account (username, password, id_role) VALUES 
        ('$username', '$hashpass', '$role')";

        $result = mysqli_query($conn, $query);

        if($result){
            redirect('../admin/users.php', 'User added successfully!');
        }
        else{
            redirect('../admin/users.php', 'Task failed.');
        }
        }
    }
    else{
        redirect('users.php', 'Please fill in the input fields');
    }



?>