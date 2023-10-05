<?php

function sidebarButton($redirect, $icon, $label, $id, $additionalClass) {
    return <<<EOT
        <a href="$redirect">
            <div id="$id" class="sidebar-button $additionalClass">
                <img src="$icon" alt="$label icon">
                <h3>$label</h3>
            </div>
        </a>
EOT;
}
