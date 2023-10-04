<?php
function sidebar($current_page, $playlists, $role) {
    $pages = array('Home', 'Poems', 'Genres', 'Creators');
    $sidebar = '<div class="sidebar">';
    $sidebar .= '<div class="upper-sidebar">';
    $sidebar .= '<h1><a href="/">Puisiku</a></h1>';
    $sidebar .= '<ul class="sidebar-pages">';

    foreach ($pages as $page) {
        $class = ($current_page == $page) ? 'active' : '';
        $lowercasePage = strtolower($page);
        $sidebar .= "<li class='$class'><a href='/$lowercasePage'>" . ucfirst($page) . "</a></li>";
    }

    $sidebar .= '</ul>';
    $sidebar .= '<ul class="sidebar-playlists">';

    foreach ($playlists as $playlist) {
        $sidebar .= "<li><a href='/playlist/$playlist'>$playlist</a></li>";
    }

    $sidebar .= '</ul>';
    $sidebar .= '</div>';

    $button_text = ($role == 'user') ? 'Be a creator!' : 'Creator Dashboard';
    $sidebar .= "<button class='sidebar-creator'><a href='/creator'>$button_text</a></button>";

    $sidebar .= '</div>';

    echo $sidebar;
}
