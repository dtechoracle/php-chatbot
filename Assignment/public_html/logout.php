<?php
session_start();

// Include necessary files
include_once("../controller/LogoutController.php");
include_once("../model/Database.php");

// Check if session variables for database connection details are set
if (isset($_SESSION['host'], $_SESSION['dbUsername'], $_SESSION['dbPassword'], $_SESSION['database'])) {
    // Retrieve database connection details from session
    $host = $_SESSION['host'];
    $dbUsername = $_SESSION['dbUsername'];
    $dbPassword = $_SESSION['dbPassword'];
    $databaseName = $_SESSION['database'];

    // Create a Database instance using session details
    $database = new Database($host, $dbUsername, $dbPassword, $databaseName);

    // Create an instance of LogoutController with the Database instance
    $logoutController = new LogoutController($database);

    // Handle logout logic
    if (isset($_POST["logout"])) {
        // Get username from session
        $username = $_SESSION['username'] ?? null;
        if ($username) {
            // Update user status to "offline" in the database
            $logoutController->updateUserStatus($username, 'offline');
        }
        // Unset the username session variable (keep other session variables)
        unset($_SESSION['username']);
        // Redirect to the login page
        header("Location: login.php");
        exit();
    }
} else {
    // Handle case where database connection details are not set in the session
    echo "Database connection details not set. Please run the installation script.";
    exit();
}
?>
