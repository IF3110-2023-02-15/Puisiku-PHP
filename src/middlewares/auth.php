<?php

class Middleware {
    public function __construct() {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getRole() {
        // Check if the 'role' session variable is set
        if(isset($_SESSION['role'])){
            // Get the 'role' session variable
            $role = $_SESSION['role'];
            return $role;
        } else {
            return null;
        }
    }

    public function isAdmin() {
        return $this->getRole() === 'admin';
    }

    public function isCreator() {
        return $this->getRole() === 'creator';
    }

    public function isUser() {
        return $this->getRole() === 'user';
    }
}
