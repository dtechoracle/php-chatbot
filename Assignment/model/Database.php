<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'assignment';

    protected $connection;

    public function __construct() {
        // Create connection
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function executeQuery($query) {
        // Logic to execute SQL queries
        $result = $this->connection->query($query);
        return $result;
    }

    // Other methods for database operations
}
?>
