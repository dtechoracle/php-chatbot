<?php
// logout.php

// Include necessary files
include_once("../controller/LogoutController.php");
include_once("../model/UserModel.php");

// Database connection details
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'assignment';

// Create instance of LogoutController with database connection details
$logoutController = new LogoutController($host, $dbUsername, $dbPassword, $database);

// Handle logout logic
if (isset($_POST["logout"])) {
    // Get username from session
    session_start();
    $username = $_SESSION['username'] ?? null;

    // If username exists, update user status to "offline" in the database
    if ($username) {
        $logoutController->updateUserStatus($username, 'offline');
    }

    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
