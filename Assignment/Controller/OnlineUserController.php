<?php
include_once("../model/OnlineUserModel.php");

class OnlineUserController {
    private $onlineUserModel;

    public function __construct(Database $database) {
        // Initialize OnlineUserModel with the Database instance
        $this->onlineUserModel = new OnlineUserModel($database);
    }

    public function getOnlineUsers() {
        // Fetch online users from the model
        return $this->onlineUserModel->getOnlineUsers();
    }
}
?>
