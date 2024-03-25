<?php
include_once("../model/UserModel.php");

class LogoutController {
    private $userModel;

    public function __construct(Database $database) {
        // Initialize UserModel with the Database instance
        $this->userModel = new UserModel($database);
    }

    public function updateUserStatus($username, $status) {
        $this->userModel->updateUserStatus($username, $status);
    }
}
?>
