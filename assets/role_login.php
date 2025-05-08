<?php
require 'dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    $sql = "SELECT id_account, username, password, id_role FROM account WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($input_password, $row["password"])) {
            session_start();
            $_SESSION["username"] = $row["username"];
            $_SESSION["id_role"] = $row["id_role"];
            switch ($row["id_role"]) {
                case "1":
                    header("Location: ../admin/dashboard.php");
                    break;
                case "2":
                    header("Location: ../captain/dashboard.php");
                    break;
                default:
                    header("Location: ../dashboard.php");
                    break;
            }
            exit();
        } else {
            header("Location: ../index.php?error=Incorrect password");
            exit();
        }
    } else {
        header("Location: ../index.php?error=User not found");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>