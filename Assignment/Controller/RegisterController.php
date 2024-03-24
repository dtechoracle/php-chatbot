<?php
include_once("../model/UserModel.php");

class RegisterController {
    private $userModel;

    public function __construct($host, $username, $password, $database) {
        // Initialize UserModel
        $this->userModel = new UserModel($host, $username, $password, $database);
    }

    public function registerUser($username, $password) {
        return $this->userModel->createUser($username, $password);
    }
}
?>
