<?php

function adminBox1($users, $offset) {
    $html = '<ol start="' . $offset + 1 . '">';
    foreach ($users as $user) {
        $id = htmlspecialchars($user['id']);
        $title = htmlspecialchars($user['title']);

        // Start output buffering
        ob_start();

        include 'poem_box.php';

        // Get the contents of the output buffer
        $userBox = ob_get_clean();
        $html .= '<li>' . $userBox . '</li>';

    }
    $html .= '</ol>';
    return $html;
}

function adminBox2($users, $offset) {
    $html = '<ol start="' . $offset + 1 . '">';
    foreach ($users as $user) {
        $id = htmlspecialchars($user['id']);
        $title = htmlspecialchars($user['username']);
        $role = htmlspecialchars($user['role']);

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


function adminBox3($users, $offset) {
    $html = '<ol start="' . $offset + 1 . '">';
    foreach ($users as $user) {
        $id = htmlspecialchars($user['id']);
        $title = htmlspecialchars($user['title']);

        // Start output buffering
        ob_start();

        include 'playlist_box.php';

        // Get the contents of the output buffer
        $userBox = ob_get_clean();
        $html .= '<li>' . $userBox . '</li>';

    }
    $html .= '</ol>';
    return $html;
}
