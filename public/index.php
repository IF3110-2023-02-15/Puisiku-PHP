<?php

require_once __DIR__ . '/../src/init.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app = new App();
