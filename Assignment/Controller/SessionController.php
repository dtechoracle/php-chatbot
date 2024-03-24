<?php
class SessionController {
    public function startSession() {
        // Logic to start a new session
        session_start();
    }

    public function destroySession() {
        // Logic to destroy the current session
        session_destroy();
    }
}
?>
