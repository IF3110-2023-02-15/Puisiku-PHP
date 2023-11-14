<?php
    $albumImagePath = getenv('REST_PUBLIC_BASE_URL') . $album->imagePath;
    $albumName = $album->name;
    $poemsCount = count($poems);
?>

<div class="premium-album-container">
    <div class="album-profile">
        <img alt="creator image" src="<?php echo $albumImagePath; ?>" />
        <div class="album-profile-info">
            <h1>
                <?php echo $albumName; ?>
            </h1>
            <h2>
                <?php echo $poemsCount; ?> poems
            </h2>
        </div>
    </div>

    <hr />

    <div class="poems-container">
        <?php
        require_once VIEWS_DIR . '/components/poems/index.php';

        foreach ($poems as $poem) {
            $onClick = '/premium/poem/' . $poem->id;
            $imagePath = getenv('REST_PUBLIC_BASE_URL') . $poem->imagePath;
            $title = $poem->title;
            $creator = "";

            echo poemBox($onClick, $imagePath, $title, $creator);
        }
        ?>

    </div>
</div>
