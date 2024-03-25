<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;

    protected $connection;

    public function __construct($host, $username, $password, $database) {
        // Set database connection details
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        // Create connection
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Getter method for the connection property
    public function getConnection() {
        return $this->connection;
    }

    public function executeQuery($query) {
        // Logic to execute SQL queries
        $result = $this->connection->query($query);
        return $result;
    }

    // Other methods for database operations
}
?>
