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

    public function getAllPoemByCreator($id){
        return $this->poemsModel->getAllPoemByCreator($id);
    }
    public function getIDPoemName(){
        return $this->poemsModel->getIDPoemName();
    }

    public function deletePoem($id){
        return $this->poemsModel->deletePoem($id);
    }

    public function getData($id){
        $poemModel = new PoemsModel();
        $poem = $poemModel->findById($id);
        return $poem;
    }
    public function create($id, $title, $genre, $content, $imagePath, $audioPath, $year){
        if ($imagePath == null) {
            $imagePath = '/img/default_playlist.png';
        }

        if ($audioPath == null) {
            $audioPath = '/audio/queencard.mp3';
        }

        try {
            $this->poemsModel->create($id, $title, $genre, $content, $imagePath, $audioPath, $year);
        } catch (PDOException $e) {
            return $e;
        }

        return SUCCESS;
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

    public function update($poemId, $title, $genre, $content, $imagePath=null, $audioPath=null) {
        $poemModel = new PoemsModel();

        try {
            $result = $poemModel->update($poemId, $title, $genre, $content, $imagePath, $audioPath);

            if ($poemId) {
                $_SESSION['poemId'] = $poemId;
            }

            if ($imagePath) {
                $_SESSION['image_poem_url'] = $imagePath;
            }

            if ($audioPath) {
                $_SESSION['audio_poem_url'] = $audioPath;
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }
}