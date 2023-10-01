<?php
require_once SRC_DIR . 'database/psql.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new PSQL();
    }

    public function create($username, $email, $hashed_password, $role="user", $image_path="/img/queencard.jpeg", $description="") {
        $sql = 'INSERT INTO Users (username, email, hashed_password, role, image_path, description) VALUES (?, ?, ?, ?, ?, ?)';
        try {
            $this->db->query($sql, [$username, $email, $hashed_password, $role, $image_path, $description]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllUsernames() {
        $sql = 'SELECT username FROM Users';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getIDUsernames(){
        $sql ='SELECT id, username FROM Users';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll() {
        $sql = 'SELECT * FROM Users';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function findById($id) {
        $sql = 'SELECT * FROM Users WHERE id = ?';
        return $this->db->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $sql = 'SELECT * FROM Users WHERE email = ?';
        return $this->db->query($sql, [$email])->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = 'DELETE CASCADE FROM Users WHERE id = ?';
        $this->db->query($sql, [$id]);
    }
}
