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

<?php
// Define variables to store errors
$usernameError = $passwordError = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include '../db_connection.php';

    // Sanitize form inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Retrieve user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Start session
            session_start();

            // Set session variables
            $_SESSION['username'] = $username;

            // Update user status to "online"
            $update_sql = "UPDATE users SET status='online' WHERE username='$username'";
            mysqli_query($conn, $update_sql);

            // Redirect to homepage or any other page after successful login
            header("Location: ../Dashboard/home.php");
            exit();
        } else {
            // Set password error
            $passwordError = 'Incorrect password!';
        }
    } else {
        // Set username error
        $usernameError = 'User not found!';
    }

    mysqli_close($conn);
}
?>


<div class="image-container"></div>

<div>
    <h2 class="center">Login</h2>
    <form class="center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <!-- Display username error -->
        <span style="color: red;"><?php echo $usernameError; ?></span><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <!-- Display password error -->
        <span style="color: red;"><?php echo $passwordError; ?></span><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
