<?php
$imagePath = getenv('REST_PUBLIC_BASE_URL') . $poem->imagePath;
$audioPath = getenv('REST_PUBLIC_BASE_URL') . $poem->audioPath;
?>

<div class="poem-container">
    <div class="poem-text-container">
        <h1>
            <?php echo $poem->title; ?>
        </h1>
        <h2>
            <?php echo $creator->name; ?>
        </h2>
        <h3>
            <?php echo $poem->genre; ?> - <?php echo $poem->year; ?>
        </h3>
        <p>
            <?php echo nl2br(htmlspecialchars($poem->content)); ?>
        </p>
    </div>
    <div class="poem-attr-container">
        <img src="<?php echo $imagePath; ?>" alt="Poem Image">
        <audio controls>
            <source src="<?php echo $audioPath; ?>" type="audio/mpeg">
        </audio>
    </div>
</div>