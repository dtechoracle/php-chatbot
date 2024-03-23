<?php
// Start session
session_start();

// Include database connection
include '../db_connection.php';

// Check if user is logged in
if (isset($_SESSION['username'])) {
    // Get username from session
    $username = $_SESSION['username'];

    // Update user status to "offline" in the database
    $update_sql = "UPDATE users SET status='offline' WHERE username='$username'";
    mysqli_query($conn, $update_sql);

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
    exit();
} else {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>
