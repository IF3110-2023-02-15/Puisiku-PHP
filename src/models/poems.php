<?php

require_once 'models.php';
require_once SRC_DIR . 'database/psql.php';

class PoemsModel extends Models {

    public function findPoems($searchKey = null, $genre = null, $page = 1, $poemsPerPage = 8, $sortBy = 'id DESC') {
        // Start building the query
        $query = "SELECT * FROM Poems";

        // Add conditions for search key and genre if they're set
        $conditions = [];
        $params = [];
        if ($searchKey !== null) {
            $conditions[] = "LOWER(title) LIKE LOWER(?)";
            $params[] = "%{$searchKey}%";
        }
        if ($genre !== null && count($genre) > 0) {
            $placeholders = implode(',', array_fill(0, count($genre), '?'));
            $conditions[] = "genre IN ($placeholders)";
            $params = array_merge($params, $genre);
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Add sorting
        $query .= " ORDER BY " . $sortBy;

        // Add pagination
        $offset = ($page - 1) * $poemsPerPage;
        $query .= " LIMIT ? OFFSET ?";

        // Add pagination parameters
        array_push($params, $poemsPerPage, $offset);

        // Execute the query and return the results
        return $this->db->query($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPoems($searchKey = null, $genre = null) {
        // Start building the query
        $query = "SELECT COUNT(*) FROM Poems";

        // Add conditions for search key and genre if they're set
        $conditions = [];
        $params = [];
        if ($searchKey !== null) {
            $conditions[] = "LOWER(title) LIKE LOWER(?)";
            $params[] = "%{$searchKey}%";
        }
        if ($genre !== null && count($genre) > 0) {
            $placeholders = implode(',', array_fill(0, count($genre), '?'));
            $conditions[] = "genre IN ($placeholders)";
            $params = array_merge($params, $genre);
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Execute the query and return the result
        return (int)$this->db->query($query, $params)->fetchColumn();
    }

    public function getAllPoemName(){
        $sql = 'SELECT title FROM Poems';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIDPoemName(){
        $sql = 'SELECT id, title FROM Poems';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllPoems(){
        $sql = 'SELECT * FROM Poems';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePoem($id) {
        $sql = 'DELETE FROM Poems WHERE id = ?';
        return $this->db->query($sql, [$id]);
    }

}

