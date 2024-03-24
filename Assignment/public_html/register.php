<?php
// Include necessary files
include_once("../controller/RegisterController.php");
include_once("../model/UserModel.php");

// Database connection details
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'assignment';

// Create instance of RegisterController with database connection details
$registerController = new RegisterController($host, $dbUsername, $dbPassword, $database);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password fields are set
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Register user
        if ($registerController->registerUser($username, $password)) {
            // Start the session
            session_start();
            // Set session variable
            $_SESSION['username'] = $username;
            // Redirect user to the dashboard upon successful registration
            header("Location: dashboard.php");
            exit();
        } else {
            // Display error message for unsuccessful registration
            echo "Registration failed. Please try again.";
        }
    } else {
        // Handle case where username or password fields are not set
        echo "Username and password fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: 60% 40%; /* Adjusted grid-template-columns */
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
            background-image: url('./image.png'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>

<!-- Your HTML content for registration page -->
<div class="image-container"></div>

<div>
    <h2 class="center">Signup</h2>
    <form class="center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Signup">
        <div class="center">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>
</div>
</body>
</html>
