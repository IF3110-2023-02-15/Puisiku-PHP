<?php

function creatorAvatar($creatorName, $avatarPath) {
    $html = <<<EOT
        <div class="creator-avatar">
            <img src="$avatarPath" />
            <h2>$creatorName</h2>
        </div>
EOT;

    return $html;
}

