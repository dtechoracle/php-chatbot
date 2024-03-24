<?php
// Include the OnlineUserController
include_once("../controller/OnlineUserController.php");

// Database connection details
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'assignment';

// Create instance of OnlineUserController with database connection details
$onlineUserController = new OnlineUserController($host, $dbUsername, $dbPassword, $database);

// Get online users from the controller
$onlineUsers = $onlineUserController->getOnlineUsers();

// Display online users
if (!empty($onlineUsers)) {
    echo "<h2>Online Users</h2>";
    echo "<ul>";
    foreach ($onlineUsers as $user) {
        echo "<li>$user</li>";
    }
    echo "</ul>";
} else {
    echo "No users are currently online.";
}
?>
