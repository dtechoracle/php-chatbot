<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';

    // Create database named 'assignment'
    $conn = new mysqli($host, $dbUsername, $dbPassword);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS assignment";
    if ($conn->query($sql) === TRUE) {
        $dbMessage = "Database created successfully<br>";

        // Switch to the 'assignment' database
        mysqli_select_db($conn, 'assignment');

        // Create 'users' table
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            status VARCHAR(10) DEFAULT 'offline'
        )";
        if ($conn->query($sql) === TRUE) {
            $tableMessage = "Table 'users' created successfully<br>";

            // Insert a sample user into the 'users' table
            $name = "sample";
            $password = password_hash("password123", PASSWORD_DEFAULT); // Hash the password
            $status = "online";

            $sql = "INSERT INTO users (name, password, status) VALUES ('$name', '$password', '$status')";
            if ($conn->query($sql) === TRUE) {
                $sampleUserMessage = "Sample user inserted successfully<br>";
            } else {
                $sampleUserMessage = "Error inserting sample user: " . $conn->error;
            }
        } else {
            $tableMessage = "Error creating table: " . $conn->error;
        }
    } else {
        $dbMessage = "Error creating database: " . $conn->error;
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

        button {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Installation</h1>
        <p>Click the button below to perform the installation tasks:</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit">Install</button>
        </form>
        <?php
        // Display installation messages
        if (isset($dbMessage)) {
            echo "<p>$dbMessage</p>";
        }
        if (isset($tableMessage)) {
            echo "<p>$tableMessage</p>";
        }
        if (isset($sampleUserMessage)) {
            echo "<p>$sampleUserMessage</p>";
        }
        ?>
    </div>
</body>
</html>
