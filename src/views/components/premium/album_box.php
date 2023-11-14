<?php

function AlbumBox($albumName, $albumImagePath) {
    $html = <<<EOT
        <div class="album-box">
            <img src="$albumImagePath" />
            <h2>$albumName</h2>
        </div>
EOT;

    return $html;
}

