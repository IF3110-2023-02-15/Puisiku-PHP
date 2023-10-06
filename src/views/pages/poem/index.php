<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poem</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/poem.css">
    <link rel="stylesheet" href="/css/back_button.css">
</head>
<body>
    <?php
    require_once VIEWS_DIR . 'components/buttons/back_button.php';
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
                <h2>Add to Playlist</h2>

                <label for="chosen-playlist">Select Playlist</label>
                <select name="chosen-playlist">
                    <option value="" selected>None</option>
                    <?php foreach ($playlists as $playlist): ?>
                        <option value="<?php echo $playlist['id']; ?>"><?php echo $playlist['title']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button class="confirm-add-to-playlist" id="confirm-add-to-playlist">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script src="/js/poem.js"></script>
</body>
</html>