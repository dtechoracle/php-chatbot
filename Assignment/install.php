<?php
session_start();

// Initialize error messages array
$errors = [
    'host' => '',
    'username' => '',
    'password' => '',
    'database' => ''
];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $host = $_POST['host'];
    $dbUsername = $_POST['username'];
    $dbPassword = $_POST['password'];
    $database = $_POST['database'];

    // Validate host
    if (empty($host)) {
        $errors['host'] = "Host is required";
    }

    // Validate username
    if (empty($dbUsername)) {
        $errors['username'] = "Username is required";
    }

    // Create database named 'assignment'
    $conn = new mysqli($host, $dbUsername, $dbPassword);
    if ($conn->connect_error) {
        $errors['password'] = "Connection failed: " . $conn->connect_error;
    } else {
        $sql = "CREATE DATABASE IF NOT EXISTS $database";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['host'] = $host;
            $_SESSION['dbUsername'] = $dbUsername;
            $_SESSION['dbPassword'] = $dbPassword;
            $_SESSION['database'] = $database;

            // Database created successfully
            $dbMessage = "Database created successfully<br>";

            // Create tables
            createTables($host, $dbUsername, $dbPassword, $database);

            // Redirect to login page
            header("Location: ./public_html/login.php");
            exit;
        } else {
            $errors['database'] = "Error creating database: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}

// Function to create tables
function createTables($host, $dbUsername, $dbPassword, $database) {
    $conn = new mysqli($host, $dbUsername, $dbPassword, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create 'users' table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        status VARCHAR(10) DEFAULT 'offline'
    )";
    if ($conn->query($sql) === TRUE) {
        // Table 'users' created successfully
        $tableMessage = "Table 'users' created successfully<br>";

        // Insert a sample user into the 'users' table
        $name = "sample";
        $password = password_hash("password123", PASSWORD_DEFAULT); // Hash the password
        $status = "online";

        $sql = "INSERT INTO users (username, password, status) VALUES ('$name', '$password', '$status')";
        if ($conn->query($sql) === TRUE) {
            // Sample user inserted successfully
            $sampleUserMessage = "Sample user inserted successfully<br>";
        } else {
            $errors['database'] = "Error inserting sample user: " . $conn->error;
        }
    } else {
        $errors['database'] = "Error creating table: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: -10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Installation</h1>
        <p>Enter your database connection details below:</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="host">Host:</label>
            <input type="text" id="host" name="host" value="<?php echo isset($_POST['host']) ? $_POST['host'] : ''; ?>" required>
            <span class="error"><?php echo $errors['host']; ?></span><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
            <span class="error"><?php echo $errors['username']; ?></span><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span class="error"><?php echo $errors['password']; ?></span><br>
            <label for="database">Database Name:</label>
            <input type="text" id="database" name="database" value="<?php echo isset($_POST['database']) ? $_POST['database'] : ''; ?>" required>
            <span class="error"><?php echo $errors['database']; ?></span><br>
            <button type="submit">Install</button>
        </form>
    </div>
</body>
</html>
