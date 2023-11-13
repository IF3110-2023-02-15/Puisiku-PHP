<div id="premium-notification" class="notification"></div>
<div class="premium">
    <div class="subscribed-container">
        <h1>Subscribed</h1>
        <div class="subscribed-creator-container">
            <?php
            require_once VIEWS_DIR . '/components/premium/creator_avatar.php';

            if (count($subscribedCreators) == 0) {
                echo "<p>No subscribed creators</p>";
            }

            foreach($subscribedCreators as $creator) {
                $creatorId = $creator->id;
                $creatorName = $creator->name;
                $imagePath = getenv('REST_PUBLIC_BASE_URL') . $creator->imagePath;

                echo "<a href='/premium/" . $creatorId . "'>";
                echo creatorAvatar($creatorName, $imagePath);
                echo "</a>";
            }
            ?>
        </div>
    </div>
    <div class="suggestion-container">
        <h1>Suggestion</h1>
        <div class="suggested-creator-container">
            <?php
            require_once VIEWS_DIR . '/components/premium/creator_avatar.php';
            require_once VIEWS_DIR . '/components/modals/subscribe_modal.php';

            if (count($creators) == 0) {
                echo "<p>No other suggested creators</p>";
            }

            foreach($creators as $creator) {
                $creatorId = $creator->id;
                $creatorName = $creator->name;
                $imagePath = getenv('REST_PUBLIC_BASE_URL') . $creator->imagePath;
                $description = $creator->description;

                echo "<div onclick=\"openSubscribeModal()\">";
                echo creatorAvatar($creatorName, $imagePath);
                echo "</div>";
                echo subscribeModal($creatorId, $creatorName, $imagePath, $description);
            }
            ?>
        </div>
    </div>
</div>
