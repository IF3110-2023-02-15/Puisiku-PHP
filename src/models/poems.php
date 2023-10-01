<?php
require_once SRC_DIR . 'database/psql.php';

class Poem {
    private $db;

    public function __construct() {
        $this->db = new PSQL();
    }

    public function getAllPoemsName(){
        $sql = 'SELECT title FROM Poems';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllPoems(){
        $sql = 'SELECT * FROM Poems';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}