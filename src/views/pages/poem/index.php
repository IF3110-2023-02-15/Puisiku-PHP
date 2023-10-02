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
    <div class="poem-container">
        <div class="poem-text-container">
            <h1>
                <?php echo $data['title']; ?>
            </h1>
            <h3>
                by: <?php echo $data['creator_name']; ?>
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
        </div>
    </div>
</body>
</html>