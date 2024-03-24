<?php
class LogModel {
    protected $logFilePath;

    public function __construct($logFilePath) {
        $this->logFilePath = $logFilePath;
    }

    public function appendToLog($message) {
        // Logic to append a message to the log file
        file_put_contents($this->logFilePath, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public function readLog() {
        // Logic to read the log file
        $logContents = file_get_contents($this->logFilePath);
        return explode(PHP_EOL, $logContents);
    }

    // Other methods for log-related operations
}
?>
