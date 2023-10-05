<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Playlist</title>
</head>
<body>
    <?php
        $info = $data['info'];
        $items = $data['items'];
    ?>

    <div class="information">
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
        </div>
    </div>

    <?php
        require_once VIEWS_DIR . 'components/table.php';

        $headers = ['#', 'Title', 'Creator', 'Genre', 'Year'];
        echo createTable($headers, $items);
    ?>

    <script defer src="/js/playlist.js"></script>
</body>
</html>