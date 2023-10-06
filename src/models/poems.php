<?php

require_once 'models.php';

class PoemsModel extends Models {
    public function buildQuery($searchKey = null, $genre = null, $year_query = null) {
        $query = "FROM Poems JOIN Users ON Poems.creator_id = Users.id ";

        // Add conditions for search key, genre and year if they're set
        $conditions = [];
        $params = [];
        if ($searchKey !== null) {
            array_push($conditions, "(LOWER(title) LIKE LOWER(?) OR LOWER(Users.username) LIKE LOWER(?))");
            array_push($params, "%{$searchKey}%", "%{$searchKey}%");
        }
        if ($genre !== null && count($genre) > 0) {
            $placeholders = implode(',', array_fill(0, count($genre), '?'));
            array_push($conditions, "genre IN ($placeholders)");
            $params = array_merge($params, $genre);
        }
        if ($year_query !== null) {
            if (count($year_query) == 2) {
                // If there are two elements in year_query, use them as the upper and lower bounds
                array_push($conditions, "year <= ? AND year >= ?");
            } else if (count($year_query) == 1) {
                // If there is one element in year_query, use it as the upper bound
                array_push($conditions, "year < ?");
            }
            array_push($params, ...$year_query);
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        return [$query, $params];
    }

    public function findPoems($searchKey = null, $genre = null, $year_query = null, $sortBy = 'Poems.created_at DESC', $page = 1, $poemsPerPage = 6) {
        // Split sortBy into column and direction
        list($sortColumn, $sortDirection) = explode(' ', $sortBy);

        // Build the query
        list($queryFrom, $params) = $this->buildQuery($searchKey, $genre, $year_query);

        // Add SELECT and FROM clauses
        $query = "SELECT Poems.id, Poems.title, Users.username, Poems.image_path " . $queryFrom;

        // Add sorting
        $query .= " ORDER BY " . $sortColumn . " " . $sortDirection;

        // Add pagination
        $offset = ($page - 1) * $poemsPerPage;
        $query .= " LIMIT ? OFFSET ?";

        // Add pagination parameters
        array_push($params, $poemsPerPage, $offset);

        try {
            $result = $this->db->query($query, $params);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error: ".$e->getMessage());
        }
    }

    public function countPoems($searchKey = null, $genre = null, $year_query = null) {
        // Build the query
        list($queryFrom, $params) = $this->buildQuery($searchKey, $genre, $year_query);

        // Add SELECT and FROM clauses
        $query = "SELECT COUNT(*) " . $queryFrom;

        try {
            return (int)$this->db->query($query,$params)->fetchColumn();
        } catch (Exception $e) {
            throw new Exception("Error: ".$e->getMessage());
        }
    }

    public function findById($id) {
        $sql = 'SELECT Poems.*, 
            (SELECT Users.username FROM Users WHERE Users.id = Poems.creator_id) AS creator_name
            FROM Poems 
            WHERE Poems.id = ?';
        return $this->db->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
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

    public function create($id, $title, $genre, $content, $imagePath, $audioPath, $year){
        $sql = 'INSERT INTO Poems (creator_id, title, genre, content, image_path, audio_path, year) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = [$id, $title, $genre, $content, $imagePath, $audioPath, $year];

        try {
            $this->db->query($sql, $params);
        } catch (Exception $e) {
            throw new Exception("Error: ".$e->getMessage());
        }
    }

    public function update($poemId, $title, $genre, $content, $imagePath = null, $audioPath = null) {
        $sql = 'UPDATE Poems SET title = ?, genre = ?, content = ?';
        $params = [$title, $genre, $content];


        if ($imagePath != null) {
            $sql .= ', image_path = ?';
            $params[] = $imagePath;
        }

        if ($audioPath != null) {
            $sql .= ', audio_path = ?';
            $params[] = $audioPath;
        }

        $sql .= ' WHERE id = ?';
        $params[] = $poemId;

        try {
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

}

