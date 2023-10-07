<?php

function poems($poems) {
    $html = '';
    foreach ($poems as $poem) {
        // Assign poem values to variables
        $id = htmlspecialchars($poem['id']);
        $img = htmlspecialchars($poem['image_path']);
        $title = htmlspecialchars($poem['title']);
        $creator = htmlspecialchars($poem['username']);

        // Start output buffering
        ob_start();

        // Include the poem_box.php file
        include 'poem_box.php';

        // Get the contents of the output buffer
        $html .= ob_get_clean();
    }
    return $html;
}

function addPoemModal() {
    $html = '';

    ob_start();
    include 'add_poem_modal.php';
    $html .= ob_get_clean();

    return $html;
}