<?php

function poemadmin($poems) {
    $html = '';
    foreach ($poems as $poem) {
        // Assign poem values to variables
        $img = htmlspecialchars($poem['image_path']);
        $title = htmlspecialchars($poem['title']);
        $genre = htmlspecialchars($poem['genre']);

        ob_start();
        $html .= ob_get_clean();
    }
    return $html;
}