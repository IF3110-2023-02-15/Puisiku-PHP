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

    public function update($playlistId, $title, $imagePath=null) {
        $playlistModel = new PlaylistsModel();
        return $playlistModel->update($playlistId, $title, $imagePath);
    }

    public function deletePlaylist($id){
        $playlistModel = new PlaylistsModel();
        return $playlistModel->deletePlaylist($id);
    }
}