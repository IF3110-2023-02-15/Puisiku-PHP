<?php

require_once 'models.php';
require_once SRC_DIR . 'database/psql.php';

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
}
