<?php
    $creator = $creatorData->creator;
    $creatorImagePath = getenv('REST_PUBLIC_BASE_URL') . $creator->imagePath;
    $creatorName = $creator->name;
    $creatorDescription = $creator->description;

    $albums = $creatorData->albums;
    $albumsCount = count($albums)
?>

<div class="premium-creator">
    <div class="creator-profile">
        <div class="image-wrapper">
            <img alt="creator image" src="<?php echo $creatorImagePath; ?>" />
        </div>
        <div class="profile-wrapper">
            <h1>
                <?php echo $creatorName; ?>
            </h1>
            <h2>
                <?php echo $albumsCount; ?> albums
            </h2>
            <p>
                <?php echo $creatorDescription; ?>
            </p>
        </div>
    </div>

    <hr />

    <div class="creator-albums">
        <?php
        require_once VIEWS_DIR . '/components/premium/album_box.php';

        foreach($albums as $album) {
            $albumId = $album->id;
            $albumName = $album->name;
            $albumImagePath = getenv('REST_PUBLIC_BASE_URL') . $album->imagePath;

            echo "<a href='/premium/album/" . $albumId . "'>";
            echo albumBox($albumName, $albumImagePath);
            echo "</a>";
        }
        ?>
    </div>
</div>
