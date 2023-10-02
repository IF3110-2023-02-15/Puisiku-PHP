<?php

require_once MODELS_DIR . 'poems.php';

class PoemsService {
    private $poemsModel;

    public function __construct() {
        $this->poemsModel = new PoemsModel();
    }

    public function getAllPoemName(){
        return $this->poemsModel->getAllPoemName();
    }
    public function getIDPoemName(){
        return $this->poemsModel->getIDPoemName();
    }

    public function deletePoem($id){
        return $this->poemsModel->deletePoem($id);
    }

    public function search($searchKey = null, $genre = null, $page = 1, $poemsPerPage = 8, $sortBy = 'id DESC') {
        $searchKey = $searchKey == '' ? null : $searchKey;
        $genre = $genre == '' ? null : $genre;

        // Find the poems
        $poems = $this->poemsModel->findPoems($searchKey, $genre, $page, $poemsPerPage, $sortBy);

        // Count the total number of poems that match the search query and genre
        $totalPoems = $this->poemsModel->countPoems($searchKey, $genre);

        // Calculate the total number of pages needed
        $totalPages = ceil($totalPoems / $poemsPerPage);

        // Return both the poems and the total count
        return [
            'poems' => $poems,
            'total_pages' => $totalPages,
        ];
    }

}