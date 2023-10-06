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
        $button_link = '';
    } elseif ($role == 'creator'){
        $button_text = 'Lets make a new Poem!';
        $button_link = '/creatorpage';
    } elseif ($role == 'admin'){
        $button_text = 'Go to admin page';
        $button_link = '/admin';
    }

    $sidebar .= sidebarButton($button_link, '/assets/icons/settings.png', $button_text, 'sidebar-settings-button', 'sidebar-settings-button');

    $sidebar .= '</div>';

    $sidebar .= <<<EOT
        
        <div class="add-playlist-modal" id="add-playlist-modal">
            <span id="close-playlist-modal-button" class="close-playlist-modal-button">&times;</span>
            <div class="add-playlist-modal-content">
                <h1>Add Playlist</h1>
                <form action="/playlist" class="add-playlist-form" id="add-playlist-form">
                    <label for="title">Title</label>
                    <input type="text" name="playlist-title" required>
                    
                    <label for="playlist-image">Playlist Image</label>
                    <input type="file" name="playlist-image" accept=".jpg, .jpeg, .png">
                    
                    <input type="submit" value="Add Playlist">
                </form>
            </div>
        </div>
        
        <div id="notification" class="notification"></div>

        <script defer src="/js/sidebar.js"></script>
EOT;


    echo $sidebar;
}
