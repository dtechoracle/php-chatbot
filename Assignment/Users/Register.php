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

<?php
// Initialize variables to store success and error messages
$successMessage = '';
$errorMessage = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include '../db_connection.php';

    // Sanitize form inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username is already taken
    $check_username_query = "SELECT * FROM users WHERE username='$username'";
    $check_username_result = mysqli_query($conn, $check_username_query);
    if (mysqli_num_rows($check_username_result) > 0) {
        $errorMessage = 'Username is already taken.';
    } else {
        // Insert user into database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hashed')";
        if (mysqli_query($conn, $sql)) {
            $successMessage = 'Signup successful!';
            header("Location: ../Dashboard/home.php");
        } else {
            $errorMessage = 'Error: ' . $sql . '<br>' . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>

<div class="image-container"></div>

<div>
    <h2 class="center">Signup</h2>
    <form class="center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <!-- Display username error -->
        <span style="color: red;"><?php echo $errorMessage; ?></span><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <!-- Display success or error message -->
        <!-- <span style="color: <?php echo $successMessage ? 'green' : 'red'; ?>"><?php echo $successMessage ? $successMessage : $errorMessage; ?></span><br> -->
        <input type="submit" value="Signup">
         <div class="center">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
    </form>
</div>
</body>
</html>
