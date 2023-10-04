<?php

require_once MODELS_DIR . 'poems.php';

class PoemsService {
    private $poemsModel;

    public function __construct() {
        $this->poemsModel = new PoemsModel();
    }

    public function search($searchKey = null, $genre = null, $year_query = null, $sort_by = 'Poems.created_at DESC', $page = 1, $poemsPerPage = 6) {
        $searchKey = $searchKey == '' ? null : $searchKey;
        $genre = $genre == '' ? null : $genre;
        $year_query = $year_query == '' ? null : $year_query;

        // Find the poems
        $poems = $this->poemsModel->findPoems($searchKey, $genre, $year_query, $sort_by, $page, $poemsPerPage);

        // Count the total number of poems that match the search query and genre
        $totalPoems = $this->poemsModel->countPoems($searchKey, $genre, $year_query);

        // Calculate the total number of pages needed
        $totalPages = ceil($totalPoems / $poemsPerPage);

        // Return both the poems and the total count
        return [
            'poems' => $poems,
            'total_pages' => $totalPages,
        ];
    }

    public function searchById($id) {
        $result = $this->poemsModel->findById($id);

        if (!$result) {
            return POEM_NOT_FOUND;
        }

        return $result;
    }
}