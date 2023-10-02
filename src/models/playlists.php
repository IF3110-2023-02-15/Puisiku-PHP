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

    public function readAllPlaylist(){
        $sql = 'SELECT * FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePlaylist($id) {
        $sql = 'DELETE FROM Playlists WHERE id = ?';
        return $this->db->query($sql, [$id]);
    }
}