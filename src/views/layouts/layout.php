<?php
function layout($current_page, $playlists, $role, $display_search, $profile_url, $content) {
    require_once VIEWS_DIR . 'components/navbar.php';
    require_once VIEWS_DIR . 'components/sidebar.php';

    ?>
    <div class="main-container">
        <?php sidebar($current_page, $playlists, $role) ?>
        <div class="sub-container">
            <?php navbar($display_search, $profile_url) ?>
            <?php echo $content; ?>
        </div>
    </div>
    <?php
}