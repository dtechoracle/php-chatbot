<?php
// LogoutController.php

class LogoutController {
    private $userModel;

    public function __construct($host, $username, $password, $database) {
        // Initialize UserModel with database connection details
        $this->userModel = new UserModel($host, $username, $password, $database);
    }

    public function updateUserStatus($username, $status) {
        // Update user status in the database
        $this->userModel->updateUserStatus($username, $status);
    }
}
?>
