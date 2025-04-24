<?php
require 'connection.php';

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT id_role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_role = $row['id_role'];
        $_SESSION['id_role'] = $id_role;
    } else {
        echo "User not found.";
        $conn->close();
        exit();
    }
    $stmt->close();

} else {
    echo "User not logged in.";
    $conn->close();
    exit();

}
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

switch ($id_role) {
    case 1:
        if ($current_page != "admin/dashboard.php") {
            header("Location: admin/dashboard.php"); // Redirect to admin dashboard
            exit();
        }
        break;
    case 2:
        if ($current_page != "captain/dashboard.php") {
            header("Location: captain/dashboard.php"); // Redirect to captain dashboard
            exit();
        }
        break;
    default:
        header("Location: dashboard.php"); // Redirect to default dashboard for all other roles
        break;
}

$conn->close();
?>
