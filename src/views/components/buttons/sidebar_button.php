<?php

function createButton($id, $additionalClass, $icon, $label) {
    return <<<EOT
        <div id="$id" class="sidebar-button $additionalClass">
            <img src="$icon" alt="$label icon">
            <h3>$label</h3>
        </div>
EOT;
}

function sidebarButton($redirect, $icon, $label, $id, $additionalClass) {
    $button = createButton($id, $additionalClass, $icon, $label);

    if ($redirect !== null) {
        return <<<EOT
            <a href="$redirect">
                $button
            </a>
EOT;
    } else {
        return $button;
    }
}
