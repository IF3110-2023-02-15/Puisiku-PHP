<?php

function adminBox1($users) {
    $html = '<ol>';
    foreach ($users as $user) {
        $id = htmlspecialchars($user['id']);
        $title = htmlspecialchars($user['title']);

        // Start output buffering
        ob_start();

        include 'user_box.php';

        // Get the contents of the output buffer
        $userBox = ob_get_clean();
        $html .= '<li>' . $userBox . '</li>';

    }
    $html .= '</ol>';
    return $html;
}

function adminBox2($users) {
    $html = '<ol>';
    foreach ($users as $user) {
        $id = htmlspecialchars($user['id']);
        $title = htmlspecialchars($user['username']);

        // Start output buffering
        ob_start();

        include 'user_box.php';

        // Get the contents of the output buffer
        $userBox = ob_get_clean();
        $html .= '<li>' . $userBox . '</li>';

    }
    $html .= '</ol>';
    return $html;
}