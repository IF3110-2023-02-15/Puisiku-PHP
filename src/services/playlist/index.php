<?php

require_once MODELS_DIR . 'playlists.php';

class PlaylistService {
    private $playlistModel;

    public function __construct() {
        $this->playlistModel = new PlaylistsModel();
    }

    public function getAllPlaylistName(){
        return $this->playlistModel->getAllPlaylistName();
    }

    public function getIDPlaylistName(){
        return $this->playlistModel->getIDPlaylistName();
    }

    public function deletePlaylist($id){
        return $this->playlistModel->deletePlaylist($id);
    }
}