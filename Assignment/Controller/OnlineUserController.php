<?php
include_once("../model/OnlineUserModel.php");

class OnlineUserController {
    private $onlineUserModel;

    public function __construct($host, $username, $password, $database) {
        // Initialize OnlineUserModel
        $this->onlineUserModel = new OnlineUserModel($host, $username, $password, $database);
    }

    public function getOnlineUsers() {
        // Fetch online users from the model
        return $this->onlineUserModel->getOnlineUsers();
    }
}
?>
