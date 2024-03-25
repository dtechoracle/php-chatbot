<?php
class OnlineUserModel {
    private $conn;

    public function __construct(Database $database) {
        // Access the database connection using the getter method
        $this->conn = $database->getConnection();
    }

    public function getOnlineUsers() {
        // Query to fetch online users
        $sql = "SELECT username FROM users WHERE status = 'online'";
        $result = $this->conn->query($sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Fetch and return the data
            $onlineUsers = array();
            while ($row = $result->fetch_assoc()) {
                $onlineUsers[] = $row['username'];
            }
            return $onlineUsers;
        } else {
            return array(); // Return an empty array if no online users found
        }
    }
}
?>
