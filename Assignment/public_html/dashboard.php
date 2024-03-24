<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include necessary files
include_once("../controller/ChatController.php");
include_once("../model/UserModel.php");

// Create instances of ChatController and UserModel
$chatController = new ChatController();
$userModel = new UserModel('localhost', 'root', '', 'assignment');

// Handle form submission to send messages
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $message = $_POST["message"];
    $username = $_SESSION['username'];

    // Send message
    $chatController->sendMessage($username, $message);
}
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
            height: 300px;
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
            margin-top: 2px;
        }

        .text-input {
            width: 100%;
        }

        /* Style for input field */
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 60%;
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
    <!-- <div class="container">
        <h1>Welcome to the Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Status: Online</p>

        <div>
            <h2>Send a Message</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <textarea name="message" rows="4" placeholder="Type your message here" required></textarea>
                <br>
                <button type="submit">Send</button>
            </form>
        </div>

        <hr>

        <h2>Chat History</h2>
        <div class="chat-history">
            <?php
            // Display chat history
            $chatHistory = $chatController->getChatHistory();
            echo nl2br($chatHistory);
            ?>
        </div>
    </div> -->

    <div class="navbar">
    <a href="#">Home</a>
    <!-- <a href="#">Online Users</a> -->
    <a href="logout.php" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
<form id="logout-form" action="logout.php" method="post" style="display: none;">
    <input type="hidden" name="logout" value="Logout">
</form>

    <div class="profile">
        <div class="username"><?php echo $_SESSION['username']; ?>!</div>
        <div class="online-status">Online</div>
    </div>
</div>

<div class="container">
    <!-- Section to display messages -->
    <div class="message-container">
       <?php
            // Display chat history
            $chatHistory = $chatController->getChatHistory();
            echo nl2br($chatHistory);
            ?>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="message" placeholder="Type your message here..." required>
        <input type="submit" value="Send">
    </form>
    <!-- Display online users -->
    <!-- <h3>Online Users</h3> -->
    <?php include 'online_users.php'; ?>
</div>

</body>
</html>

<script>
document.getElementById("logoutLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default link behavior

    // Make an AJAX request to the logout endpoint
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Redirect to the login page after successful logout
            window.location.href = "login.php";
        }
    };
    xhttp.open("POST", "../controller/LogoutController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
});
</script>
