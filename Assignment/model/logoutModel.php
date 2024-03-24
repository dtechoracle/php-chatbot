<?php
class LogoutModel {
    public function logoutUser() {
        // Check if session exists
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Unset all session variables
            $_SESSION = array();
            // Destroy the session
            session_destroy();
        }
        // Redirect to the login page or any other desired page after logout
        header("Location: ../public_html/login.php");
        exit();
    }
}
?>
