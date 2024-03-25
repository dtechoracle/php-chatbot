<?php
require_once('Database.php');

class UserModel {
    private $db;

    public function __construct(Database $db) {
        // Set the database connection
        $this->db = $db;
    }

    public function authenticateUser($username, $password) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $this->db->executeQuery($sql);
        
        // Check if the query execution was successful
        if ($result !== false) {
            // Check if the query returned exactly one row
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
        } else {
            // Query execution failed
            return false;
        }
    }

    public function registerUser($username, $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user into the database
    $stmt = $this->db->getConnection()->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // Registration successful
    } else {
        return false; // Registration failed
    }
}


    public function updateUserStatus($username, $status) {
        $sql = "UPDATE users SET status='$status' WHERE username='$username'";
        if ($this->db->executeQuery($sql)) {
            // Status updated successfully
            return true;
        } else {
            // Error updating status
            return false;
        }
    }
}
?>
