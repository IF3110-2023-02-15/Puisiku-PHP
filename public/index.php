<?php

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the notification message is set
if (isset($_SESSION['notification'])) {
    // Display the notification
    echo Notification::show($_SESSION['notification']);

    // Unset the notification message so it doesn't keep showing up on refresh
    unset($_SESSION['notification']);
}

require_once __DIR__ . '/../src/init.php';

$app = new App();
