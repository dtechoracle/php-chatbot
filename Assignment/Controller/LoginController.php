<?php
include_once("../model/UserModel.php");

class LoginController {
    private $userModel;

    public function __construct($host, $username, $password, $database) {
        // Initialize UserModel
        $this->userModel = new UserModel($host, $username, $password, $database);
    }

    public function login($username, $password) {
        return $this->userModel->authenticateUser($username, $password);
    }

    public function updateUserStatus($username, $status) {
    $this->userModel->updateUserStatus($username, $status);
}
}
?>
