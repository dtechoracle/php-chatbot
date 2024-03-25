<?php
session_start();

// Check if session variables for database connection details are set
if (isset($_SESSION['host'], $_SESSION['dbUsername'], $_SESSION['dbPassword'], $_SESSION['database'])) {
    // Database connection details
    $host = $_SESSION['host'] ?? '';
    $dbUsername = $_SESSION['dbUsername'] ?? '';
    $dbPassword = $_SESSION['dbPassword'] ?? '';
    $databaseName = $_SESSION['database'] ?? '';

    // Include necessary files
    require_once('../model/Database.php');
    include_once("../model/UserModel.php");
    include_once("../controller/LoginController.php");
    include_once("../controller/LogoutController.php");

    // Instantiate Database with session details
    $database = new Database($host, $dbUsername, $dbPassword, $databaseName);

    // Instantiate UserModel with Database instance
    $userModel = new UserModel($database);

    // Instantiate LoginController with UserModel instance
    $loginController = new LoginController($userModel);
    $logoutController = new LogoutController($database);

    // Initialize error variables
    $usernameError = '';
    $passwordError = '';

    // Handle login logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the username and password fields are set
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Authenticate user
            if ($loginController->login($username, $password)) {
                // Update user status to "online" in the database
                $loginController->updateUserStatus($username, 'online');
                // Set session variable
                $_SESSION['username'] = $username;
                // Redirect user to the dashboard or another page upon successful login
                header("Location: dashboard.php");
                exit();
            } else {
                // Set error message for invalid login credentials
                $usernameError = "Invalid username or password. Please try again.";
            }
        } else {
            // Handle case where username or password fields are not set
            $usernameError = "Username and password fields are required.";
        }
    }

    // Handle logout logic
    if (isset($_POST["logout"])) {
        // Get username from session
        $username = $_SESSION['username'] ?? null;
        if ($username) {
            // Update user status to "offline" in the database
            $logoutController->updateUserStatus($username, 'offline');
        }
        // Destroy the session and redirect to the login page
        session_destroy();
        header("Location: login.php");
        exit();
    }
} else {
    echo "Database connection details not set. Please run the installation script.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: 60% 40%;
        }
        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .center {
            text-align: center;
        }
        .image-container {
            background-image: url('./image.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>

<div class="image-container"></div>

<div>
    <h2 class="center">Login</h2>
    <form class="center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <span style="color: red;"><?php echo $usernameError; ?></span><br> <!-- Display username error -->
        <input type="password" name="password" placeholder="Password" required><br>
        <span style="color: red;"><?php echo $passwordError; ?></span><br> <!-- Display password error -->
        <input type="submit" value="Login">

        <p class="center">Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>
</body>
</html>
