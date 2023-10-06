<?php

function playlistModal($idPrefix, $action, $title = '', $image = '', $isUpdate = false) {
    $submitValue = $isUpdate ? 'Update Playlist' : 'Add Playlist';
    $imagePath = empty($image) ? '/img/default_playlist.png' : $image;

    return '
    <div class="playlist-modal" id="' . $idPrefix . '-playlist-modal">
        <span id="' . $idPrefix . '-playlist-close-button" class="close-button">×</span>
        
        <div class="playlist-modal-content">
        
            <h1>' . $action . ' Playlist</h1>
            
            <img src="' . $imagePath . '" id="' . $idPrefix . '-playlist-img" alt="Playlist Image"> 
            
            <form action="/playlist" class="playlist-form" id="' . $idPrefix . '-playlist-form">
                <label for="title">Title</label>
                <input type="text" name="playlist-title" value="' . $title . '" required>
                
                <label for="playlist-image">Playlist Image</label>
                <input type="file" id="' . $idPrefix . '-playlist-image-input" name="playlist-image" accept=".jpg, .jpeg, .png">
                
                <input type="submit" value="' . $submitValue . '">
            </form>
        </div>
    </div>
    ';
}

