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

    public function getAllPlaylistName(){
        $sql = 'SELECT title FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIDPlaylistName(){
        $sql = 'SELECT id, title FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIDStatusPlaylistName(){
        $sql = 'SELECT id, title, is_private FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTitlePlaylist($id){
        $sql = 'SELECT title FROM Playlists WHERE id = ?';
        return $this->db->query($sql, [$id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllPlaylist(){
        $sql = 'SELECT * FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePlaylist($id) {
        $sql = 'DELETE FROM Playlists WHERE id = ?';
        return $this->db->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($playlistId, $status){
        $sql = 'UPDATE Playlists SET is_private = ?';
        $params = [$status];

        $sql .= ' WHERE id = ?';
        $params[] = $playlistId;

        try {
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    public function update($playlistId, $title, $imagePath = null) {
        $sql = 'UPDATE Playlists SET title = ?';
        $params = [$title];


        if ($imagePath != null) {
            $sql .= ', image_path = ?';
            $params[] = $imagePath;
        }

        $sql .= ' WHERE id = ?';
        $params[] = $playlistId;

        try {
            return $this->db->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    public function createPlaylist($ownerId, $title, $imagePath) {
        $sql = 'INSERT INTO Playlists (title, owner_id, image_path) VALUES (?,?,?) RETURNING *';

        return $this->db->query($sql, [$title, $ownerId, $imagePath])->fetch(PDO::FETCH_ASSOC);
    }
}