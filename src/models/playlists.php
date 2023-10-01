<?php
require_once SRC_DIR . 'database/psql.php';

class Playlist {
    private $db;

    public function __construct() {
        $this->db = new PSQL();
    }

    public function getAllPlaylistName(){
        $sql = 'SELECT title FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllPlaylist(){
        $sql = 'SELECT * FROM Playlists';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}