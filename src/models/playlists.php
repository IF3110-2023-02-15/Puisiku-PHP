<?php

require_once 'models.php';

class PlaylistsModel extends Models {

    public function getUserPlaylists($userId) {
        $sql = 'SELECT id, title, image_path FROM Playlists WHERE owner_id = ?';

        return $this->db->query($sql, [$userId])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlaylistData($playlistId) {
        $sql = 'SELECT id, title, image_path, DATE(updated_at) FROM Playlists WHERE id = ?';

        return $this->db->query($sql, [$playlistId])->fetch(PDO::FETCH_ASSOC);
    }
}