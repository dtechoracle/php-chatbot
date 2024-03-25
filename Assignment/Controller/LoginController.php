<?php
include_once("../model/UserModel.php");

class LoginController {
    private $userModel;

    // Update the constructor to accept a UserModel instance
    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    // Add a login method to use the authenticateUser() method of UserModel
    public function login($username, $password) {
        return $this->userModel->authenticateUser($username, $password);
    }

    // Add any other methods as needed
    public function updateUserStatus($username, $status) {
        $this->userModel->updateUserStatus($username, $status);
    }
}
?>
