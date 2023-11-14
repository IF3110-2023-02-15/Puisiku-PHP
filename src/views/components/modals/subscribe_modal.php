<?php

function subscribeModal($creatorId, $creatorName, $imagePath, $description) {
    $html = <<<EOT
        <div class="subscribe-modal">
            <div class="subscribe-modal-content">
                <img src="$imagePath" />
                <h1>$creatorName</h1>
                <p>$description</p>
                <div class="buttons-container">
                    <button onclick="closeSubscribeModal()">Close</button>
                    <button onclick="subscribe($creatorId)">Subscribe</button>
                </div>
            </div>
        </div>
EOT;

    return $html;
}


