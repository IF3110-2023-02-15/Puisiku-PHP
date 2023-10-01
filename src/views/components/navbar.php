<?php

function navbar($display_search, $profile_url) {
    $search_bar = '';
    if ($display_search) {
        ob_start();
        include 'search.php';
        $search_bar = ob_get_clean();
    }

    $navbar = <<<EOT
    <div class="navbar">
        <div class="profile-button">
            <a href="/profile">
                <img src="$profile_url" alt="Profile" class="profile-image">
            </a>
        </div>
        $search_bar
    </div>
EOT;

    echo $navbar;
}
