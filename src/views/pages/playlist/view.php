<?php
    $info = $data['info'];
    $items = $data['items'];

    require_once VIEWS_DIR . 'components/modals/confirmation_modal.php';
    require_once VIEWS_DIR . 'components/modals/playlist_modal.php';

    echo confirmationModal('update-playlist', 'Are you sure to update the playlist?');
    echo confirmationModal('delete-playlist', 'Are you sure to delete the playlist?');

    echo playlistModal('edit', 'Edit', $info['title'], $info['image_path']);
?>

<div id="playlist-notification" class="notification"></div>

<div id="information" class="information" data-playlist-id="<?php echo $info['id']; ?>">
    <div class="playlist-image-container">
        <img src="<?php echo $info["image_path"]; ?>" alt="Playlist Image">
    </div>
    <div class="playlist-info-container">
        <h1>
            <?php echo $info['title'] ?>
        </h1>
        <h3>
            last updated <?php echo $info['date'] ?>
        </h3>
        <div class="playlist-update-delete">
            <button class="edit-playlist" id="edit-playlist">
                Edit
            </button>
            <button class="delete-playlist" id="delete-playlist">
                Delete
            </button>
        </div>
    </div>
</div>

<div class="playlist-table-container">
    <?php
        require_once VIEWS_DIR . 'components/table.php';

        $headers = ['#', 'Title', 'Creator', 'Genre', 'Year'];
        echo createTable($headers, $items);
    ?>
</div>

<script defer src="/js/playlist.js"></script>
