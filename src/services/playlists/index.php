<?php

require_once MODELS_DIR . 'playlists.php';
require_once MODELS_DIR . 'playlist_items.php';

class PlaylistsService {

    public function getUserPlaylists($userId) {
        $playlistsModel = new PlaylistsModel();

        $result = $playlistsModel->getUserPlaylists($userId);

        return $result;
    }

    public function getPlaylist($playlistId) {
        $playlistsModel = new PlaylistsModel();
        $playlistItemsModel = new PlaylistItemsModel();

        $playlist_data = $playlistsModel->getPlaylistData($playlistId);
        $playlist_items = $playlistItemsModel->getPlaylistPoems($playlistId);

        return [
            'info' => $playlist_data,
            'items' => $playlist_items
        ];
    }

    public function getPlaylistItems($playlistId) {
        $playlistItemsModel = new PlaylistItemsModel();
        return $playlistItemsModel->getPlaylistPoems($playlistId);
    }

    public function addPlaylist($ownerId, $title, $image_path) {
        $playlistsModel = new PlaylistsModel();

        if ($image_path == null) {
            $image_path = '/img/default_playlist.png';
        }

        return $playlistsModel->createPlaylist($ownerId, $title, $image_path);
    }

    public function addPlaylistItem($playlistId, $poemId) {
        $playlistItemsModel = new PlaylistItemsModel();

        $hasExist = $playlistItemsModel->getPair($playlistId, $poemId);

        if ($hasExist) {
            throw new Exception('This poem has already in the playlist.');
        }

        return $playlistItemsModel->addPlaylistPoem($playlistId, $poemId);
    }

    

    public function deletePlaylist($id){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->deletePlaylist($id);
    }

    public function deletePlaylistItem($playlistId, $poemId) {
        $playlistItemsModel = new PlaylistItemsModel();
        return $playlistItemsModel->delete($playlistId, $poemId);
    }

    public function getAllPlaylistName(){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->getAllPlaylistName();
    }

    public function getIDPlaylistName(){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->getIDPlaylistName();
    }
    public function getIDStatusPlaylistName(){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->getIDStatusPlaylistName();
    }

    public function getTitle($id){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->getTitlePlaylist($id);
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

        if ($imagePath == null) {
            $imagePath = '/img/default_playlist.png';
        }

        try {
            $result = $playlistModel->update($playlistId, $title, $imagePath);

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating playlist: ' . $e->getMessage());
        }
    }

    // public function update($playlistId, $title, $imagePath=null) {
    //     $playlistModel = new PlaylistsModel();
    //     return $playlistModel->update($playlistId, $title, $imagePath);
    // }
}