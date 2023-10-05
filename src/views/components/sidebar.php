<?php

require_once VIEWS_DIR . 'components/buttons/sidebar_button.php';

function sidebar($current_page, $playlists, $role) {
    $pages = array('Home', 'Poems', 'Genres', 'Creators');
    $pagesLogo = array('/assets/icons/home.png', '/assets/icons/home.png', '/assets/icons/home.png', '/assets/icons/home.png');

    // Start building the sidebar
    $sidebar = <<<EOT
        <div class="sidebar">
            <div class="upper-sidebar">
                <h1><a href="/">Puisiku</a></h1>
                <ul class="sidebar-pages">
EOT;

    // Add each page to the sidebar
    foreach ($pages as $key => $page) {
        $class = ($current_page == $page) ? 'active' : '';
        $lowercasePage = '/' . strtolower($page);
        $logo = $pagesLogo[$key];

        $sidebar .= "<li class='sidebar-list'>";
        $sidebar .= sidebarButton($lowercasePage, $logo, $page, '', $class);
        $sidebar .= "</li>";
    }

    $sidebar .= "</ul> <div class='sidebar-add-playlist-container'>";

    $sidebar .= sidebarButton('', '/assets/icons/add.svg', 'Add Playlist', 'add-playlist-button', 'sidebar-add-playlist-button');

    $sidebar .= '</div> <ul class="sidebar-playlist">';

    // Decode the playlists JSON and add each playlist to the sidebar
    foreach (json_decode($playlists, true) as $playlist) {
        $playlistId = $playlist['id'];
        $playlistTitle = $playlist['title'];
        $playlistImagePath = $playlist['image_path'];

        $class = ($current_page == $playlistId) ? 'active' : '';

        $sidebar .= "<li class='sidebar-list'>";
        $sidebar .= sidebarButton('/playlist/' . $playlistId, $playlistImagePath, $playlistTitle, 'playlist-'. $playlistId, $class);
        $sidebar .= "</li>";
    }

    // Close the playlists list
    $sidebar .= '</ul></div>';

    $button_text = '';
    $button_link = '';

    // Close the sidebar divs
    if ($role == 'user'){
        $button_text = 'Be a creator!';
        $button_link = '';
    } elseif ($role == 'creator'){
        $button_text = 'Lets make a new Poem!';
        $button_link = '/creatorpage';
    } elseif ($role == 'admin'){
        $button_text = 'Go to admin page';
        $button_link = '/admin';
    }

//    $sidebar .= "<button class='sidebar-creator'><a href='$button_link'>$button_text</a></button>";
    $sidebar .= sidebarButton($button_link, '/assets/icons/settings.png', $button_text, 'sidebar-settings-button', 'sidebar-settings-button');

    $sidebar .= '</div>';

    echo $sidebar;
}
