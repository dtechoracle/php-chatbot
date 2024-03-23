<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if not logged in
    header("Location: Users/login.php");
    exit();
}

// Include database connection
include '../db_connection.php';

// Get the username from the session
$username = $_SESSION['username'];

// Update user's status to "online" in the database
$update_online_status = mysqli_query($conn, "UPDATE users SET status='online' WHERE username='$username'");

// Fetch online users from the database
$online_users_query = mysqli_query($conn, "SELECT username FROM users WHERE status='online'");
$online_users = [];
while ($row = mysqli_fetch_assoc($online_users_query)) {
    $online_users[] = $row['username'];
}

// Check if the message form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the message field is not empty
    if (!empty($_POST['message'])) {
        // Sanitize the message
        $message = htmlspecialchars($_POST['message']);
        
        // Add the message to the message log file
        $file = 'messages.txt';
        $current = file_get_contents($file);
        $current .= "<div class='message'><span class='sender'>$username:</span> $message</div>";
        file_put_contents($file, $current);
    }
}

// Read the message log file
$message_log = file_get_contents('messages.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .username {
            font-weight: bold;
            font-size: 20px;
            color: white;
        }

        .status {
            color: green;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            padding-top: 10px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .message-container {
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .message {
            position: relative;
            background: #00bfff;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 25px;
            max-width: 70%;
        }

        .message:after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: calc(3% - 10px);
            border: solid transparent;
            border-width: 20px;
            border-top-color: #00bfff;
            border-bottom: 0;
            border-left: 0;
        }

        .message .sender {
            font-weight: bold;
            color: blue;
        }

        .online-status {
            color: green;
        }

        .profile {
            text-align: right;
            padding-right: 20px;
        }

        .text-input {
            width: 100%;
        }

        /* Style for input field */
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Style for button */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Hover effect for button */
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Focus effect for input field */
        input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Media query for mobile responsiveness */
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .message {
                max-width: 100%;
            }

            .navbar {
                padding-top: 5px;
            }

            .navbar a {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="#">Home</a>
    <!-- <a href="#">Online Users</a> -->
    <a href="../Users/logout.php">Logout</a>
    <div class="profile">
        <div class="username"><?php echo $username; ?></div>
        <div class="online-status">Online</div>
    </div>
</div>

<div class="container">
    <!-- Section to display messages -->
    <div class="message-container">
        <?php echo $message_log; ?>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="message" placeholder="Type your message here..." required>
        <input type="submit" value="Send">
    </form>
    <!-- Display online users -->
    <h3>Online Users</h3>
    <ul>
        <?php foreach ($online_users as $user): ?>
            <li><?php echo ($user == $username) ? "You" : $user; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    // Function to scroll to the bottom of the message container
    function scrollToBottom() {
        var messageContainer = document.querySelector('.message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    // Call the scrollToBottom function on page load
    window.onload = scrollToBottom;

    // Call the scrollToBottom function after submitting a message
    document.querySelector('form').addEventListener('submit', function() {
        scrollToBottom();
    });
</script>

</body>
</html>
