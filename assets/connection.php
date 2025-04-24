<?php
$first_time_setup = true;

if (isset($_COOKIE['first_time'])) {
    $first_time_setup = false;
}

$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "smart_streetlight";

if ($first_time_setup) {
    $conn = new mysqli($host, $dbuser, $dbpass);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql_create_db) === TRUE) {
    } else {
    }
    $conn->close();

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_users_table_sql = "SHOW TABLES LIKE 'account'";
    $check_roles_table_sql = "SHOW TABLES LIKE 'account_role'";

    $users_table_exists = $conn->query($check_users_table_sql)->num_rows > 0;
    $roles_table_exists = $conn->query($check_roles_table_sql)->num_rows > 0;


    // Create tables (example tables)
    if (!$users_table_exists) {
        $sql_create_users_table = "CREATE TABLE IF NOT EXISTS account (
            id_account INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            id_role INT NOT NULL
        )";
        if ($conn->query($sql_create_users_table) === TRUE) {
        } else {

        }
    } else {
    }


    if (!$roles_table_exists) {
        $sql_create_roles_table = "CREATE TABLE IF NOT EXISTS account_role (
            id_role INT AUTO_INCREMENT PRIMARY KEY,
            value VARCHAR(50) NOT NULL UNIQUE
        )";
        if ($conn->query($sql_create_roles_table) === TRUE) {
        } else {
        }
    } else {
    }

    if ($roles_table_exists) {
        $sql_insert_roles = "INSERT IGNORE INTO account_role (value) VALUES ('admin'), ('captain'), ('user')";
         if ($conn->query($sql_insert_roles) === TRUE) {
        } else {
        }
    }

    if ($users_table_exists) {
        $sql_insert_admin = "INSERT IGNORE INTO account (username, password, id_role) VALUES ('admin', 'admin', 1)";
        if ($conn->query($sql_insert_admin) === TRUE) {
        } else {
        }
    }

    $conn->close();

    setcookie("first_time", "true", time() + (365 * 24 * 60 * 60));
} else {
}