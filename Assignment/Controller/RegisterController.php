<?php
include_once("../model/UserModel.php");

class RegisterController {
    private $userModel;

    public function __construct(Database $database) {
        // Initialize UserModel with the provided Database object
        $this->userModel = new UserModel($database);
    }

    public function registerUser($username, $password) {
        // Call the registerUser method of UserModel
        return $this->userModel->registerUser($username, $password);
    }
}
?>
