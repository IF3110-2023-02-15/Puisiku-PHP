<?php
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
        $lowercasePage = strtolower($page);
        $logo = $pagesLogo[$key];

        $sidebar .= "
            <li class='sidebar-list $class'>
                <a href='/$lowercasePage'>
                    <img src='$logo' alt=''>
                    " . ucfirst($page) . "
                </a>
            </li>
        ";
    }

    // Close the pages list and open the playlists list
    $sidebar .= <<<EOT
        </ul>
        
        <button class="add-playlist-btn" id="add-playlist-btn">
            <img src="" alt="Add Button">Add Playlist
        </button>
        
        <ul class="sidebar-playlists">
EOT;

    // Decode the playlists JSON and add each playlist to the sidebar
    foreach (json_decode($playlists, true) as $playlist) {
        $playlistId = $playlist['id'];
        $playlistTitle = $playlist['title'];
        $playlistImagePath = $playlist['image_path'];

        $class = ($current_page == $playlistId) ? 'active' : '';

        $sidebar .= "
            <li class='sidebar-list $class'>
                <a href='/playlist/$playlistId'>
                    <img src='$playlistImagePath' alt='Playlist Image'>
                    $playlistTitle
                </a>
            </li>";
    }

    // Close the playlists list
    $sidebar .= '</ul></div>';

    $button_text = '';
    $button_link = '';

    // Close the sidebar divs
    if ($role == 'user'){
        $button_text = 'Be a creator!';
        $button_link = '/upgrade';
    } elseif ($role == 'creator'){
        $button_text = 'Lets make a new Poem!';
        $button_link = '/creator';
    } elseif ($role == 'admin'){
        $button_text = 'Go to admin page';
        $button_link = '/admin';
    }

    $sidebar .= "<button class='sidebar-creator'><a href='$button_link'>$button_text</a></button>";
    $sidebar .= '</div>';

    echo $sidebar;
}
