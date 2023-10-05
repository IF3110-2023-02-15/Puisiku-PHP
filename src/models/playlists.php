<?php
require_once 'models.php';
require_once SRC_DIR . 'database/psql.php';

class PlaylistsModel {
    private $db;

    public function __construct() {
        $this->db = new PSQL();
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

    public function readAllPlaylist(){
        $sql = 'SELECT * FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePlaylist($id) {
        $sql = 'DELETE FROM Playlists WHERE id = ?';
        return $this->db->query($sql, [$id]);
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
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }
}