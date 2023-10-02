<?php

function poems($poems) {
    $html = '';
    foreach ($poems as $poem) {
        // Assign poem values to variables
        $img = htmlspecialchars($poem['image_path']);
        $title = htmlspecialchars($poem['title']);
        $genre = htmlspecialchars($poem['genre']);

        // Start output buffering
        ob_start();

        // Include the poem_box.php file
        include 'poem_box.php';

        // Get the contents of the output buffer
        $html .= ob_get_clean();
    }
    return $html;
}
