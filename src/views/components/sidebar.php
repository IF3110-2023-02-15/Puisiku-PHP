<?php

require_once VIEWS_DIR . 'components/buttons/sidebar_button.php';
require_once VIEWS_DIR . 'components/modals/confirmation_modal.php';
require_once VIEWS_DIR . 'components/modals/playlist_modal.php';

function sidebar($current_page, $playlists, $role) {
    $pages = array('Home', 'Poems', 'Genres', 'Creators');
    $pagesLogo = array('/assets/icons/home.png', '/assets/icons/home.png', '/assets/icons/home.png', '/assets/icons/home.png');

    $sidebar = confirmationModal('upgrade-role', 'Are you sure to be a creator? This action is not reversible!');

    // Start building the sidebar
    $sidebar .= <<<EOT
        <div class="sidebar">
            <div class="upper-sidebar">
                <h1><a href="/">P<span>uisiku</span></a></h1>
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

    $sidebar .= sidebarButton(null, '/assets/icons/add.svg', 'Add Playlist', 'add-playlist-button', 'sidebar-add-playlist-button');

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
        $button_link = null;
    } elseif ($role == 'creator'){
        $button_text = 'Lets make a new Poem!';
        $button_link = '/creator';
    } elseif ($role == 'admin'){
        $button_text = 'Go to admin page';
        $button_link = '/admin';
    }

    $sidebar .= sidebarButton($button_link, '/assets/icons/settings.png', $button_text, 'sidebar-settings-button', 'sidebar-settings-button');

    $sidebar .= '</div>';

    $sidebar .= playlistModal('add', 'Add');

    $sidebar .= <<<EOT
        <div id="notification" class="notification"></div>
        <script defer src="/js/sidebar.js"></script>
EOT;

    echo $sidebar;
}
