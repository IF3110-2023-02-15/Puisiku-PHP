<?php
function navbar($display_search, $profile_url) {
    $search_bar = '';
    if ($display_search) {
        $search_bar = <<<EOT
        <input type="text" placeholder="Search..." class="search-bar">
EOT;
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
