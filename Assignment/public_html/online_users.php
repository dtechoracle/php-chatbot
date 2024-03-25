<?php
// session_start();

// Include necessary files
include_once("../controller/OnlineUserController.php");
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

    // Create an instance of OnlineUserController with the Database instance
    $onlineUserController = new OnlineUserController($database);

    // Get online users
    $onlineUsers = $onlineUserController->getOnlineUsers();

    // Display online users
    if (!empty($onlineUsers)) {
        echo "<h3>Online Users</h3>";
        echo "<ul>";
        foreach ($onlineUsers as $user) {
            echo "<li>$user</li>";
        }
        echo "</ul>";
    } else {
        echo "No online users.";
    }
} else {
    // Handle case where database connection details are not set in the session
    echo "Database connection details not set. Please run the installation script.";
}
?>
