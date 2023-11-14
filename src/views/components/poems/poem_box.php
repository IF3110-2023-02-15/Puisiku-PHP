<?php
function poemBox($onClick, $img, $title, $creator) {
    echo '<div class="poem" onclick="window.location=\'' . $onClick . '\'">';
    echo '<img src="' . $img . '" alt="" class="poem-img">';
    echo '<h1>' . $title . '</h1>';
    echo '<h2>' . $creator . '</h2>';
    echo '</div>';
}

