<?php
class ChatController {
    private $logFile;

    public function __construct() {
        $this->logFile = "chatlog.txt";
    }

    public function sendMessage($username, $message) {
        $formattedMessage = $username . ": " . $message . PHP_EOL;
        $this->appendMessageToFile($formattedMessage);
    }

    public function getChatHistory() {
        return $this->readChatHistoryFromFile();
    }

    private function appendMessageToFile($message) {
        $logFile = fopen($this->logFile, "a");
        fwrite($logFile, $message);
        fclose($logFile);
    }

    private function readChatHistoryFromFile() {
        $chatHistory = "";
        if (file_exists($this->logFile)) {
            $chatHistory = file_get_contents($this->logFile);
        }
        return $chatHistory;
    }
}
?>
