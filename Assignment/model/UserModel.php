<?php
class UserModel {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        // Establish database connection
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function authenticateUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // User authenticated successfully
                return true;
            } else {
                // Incorrect password
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }

    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        if ($this->conn->query($sql) === TRUE) {
            // User registered successfully
            return true;
        } else {
            // Error occurred while registering user
            return false;
        }
    }

  public function updateUserStatus($username, $status) {
        $sql = "UPDATE users SET status='$status' WHERE username='$username'";
        $result = $this->conn->query($sql);
        if ($result) {
            // Status updated successfully
            return true;
        } else {
            // Error updating status
            return false;
        }
    }
}
?>
