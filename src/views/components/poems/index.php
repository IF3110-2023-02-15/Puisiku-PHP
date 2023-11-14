<?php

require_once 'poem_box.php';

function poems($poems) {
    $html = '';
    foreach ($poems as $poem) {
        // Assign poem values to variables
        $id = htmlspecialchars($poem['id']);
        $imagePath = htmlspecialchars($poem['image_path']);
        $title = htmlspecialchars($poem['title']);
        $creator = htmlspecialchars($poem['username']);

        $onClick = '/poem/' . $id;

        ob_start();
        poemBox($onClick, $imagePath, $title, $creator);
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