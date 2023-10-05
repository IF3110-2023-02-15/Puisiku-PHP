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
    public function getIDStatusPlaylistName(){
        return $this->playlistModel->getIDStatusPlaylistName();
    }

    public function deletePlaylist($id){
        return $this->playlistModel->deletePlaylist($id);
    }

    public function updateStatus($playlistId, $status) {
        $playlistModel = new PlaylistsModel();

        try {
            $result = $playlistModel->updateStatus($playlistId, $status);

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

    public function update($playlistId, $title, $imagePath=null) {
        $playlistModel = new PlaylistsModel();

        try {
            $result = $playlistModel->update($playlistId, $title, $imagePath=null);


            if ($imagePath) {
                $_SESSION['image_poem_url'] = $imagePath;
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }
}