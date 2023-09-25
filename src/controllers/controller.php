<?php

require_once VIEWS_DIR . 'components/notification.php';

class Controller {
    public function view($view, $data = []) {
        // Extract the data array to variables for use in the view
        extract($data);

        // Include the view file
        require_once PAGES_DIR . $view . '.php';
    }

    public function loadPageNotFound() {
        $this->view('errors/index');
    }

    public function showNotification($message) {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Store the notification message in a session variable
        $_SESSION['notification'] = $message;
    
        // Redirect to the dashboard
        header("Location: /dashboard");
    }
    
}
