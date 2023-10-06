<?php

function confirmationModal($idPrefix, $label) {
    return '
    <div id="' . $idPrefix . '-confirmation-modal" class="confirmation-modal">
        <span id="' . $idPrefix . '-close-button" class="close-button">×</span>
        <div class="modal-content">
            <h2>'.$label.'</h2>
            <div class="button-container">
                <button id="' . $idPrefix . '-yes-button">Yes</button>
                <button id="' . $idPrefix . '-no-button">No</button>
            </div>
        </div>
    </div>
    ';
}
