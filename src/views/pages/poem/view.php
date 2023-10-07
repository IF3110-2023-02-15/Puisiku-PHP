<?php
    $playlistsDecoded = json_decode($playlists, true);
?>

<div id="notification" class="notification"></div>

<div class="poem-container">
    <div class="poem-text-container">
        <h1>
            <?php echo $data['title']; ?>
        </h1>
        <h2>
            <?php echo $data['creator_name']; ?>
        </h2>
        <h3>
            <?php echo $data['genre']; ?> - <?php echo $data['year']; ?>
        </h3>
        <p>
            <?php echo nl2br(htmlspecialchars($data['content'])); ?>
        </p>
    </div>
    <div class="poem-attr-container">
        <img src="<?php echo $data['image_path']; ?>" alt="Poem Image">
        <audio controls>
            <source src="<?php echo $data['audio_path']; ?>" type="audio/mpeg">
        </audio>
        <button class="poem-add-to-playlist" id="poem-add-to-playlist">
            Add to Playlist
        </button>
    </div>

    <div id="poem-modal-add-to-playlist" class="poem-modal-add-to-playlist" data-poem-id="<?php echo $data['id']; ?>">
        <span id="playlist-modal-close-button" class="playlist-modal-close-button">&times;</span>

        <div class="choose-able-playlist-container">
            <h1>Add to Playlist</h1>

            <label for="chosen-playlist">Select Playlist</label>
            <select name="chosen-playlist">
                <option value="" selected>None</option>
                <?php foreach ($playlistsDecoded as $playlist): ?>
                    <option value="<?php echo $playlist['id']; ?>"><?php echo $playlist['title']; ?></option>
                <?php endforeach; ?>
            </select>

            <button class="confirm-add-to-playlist" id="confirm-add-to-playlist">
                Confirm
            </button>
        </div>
    </div>
</div>