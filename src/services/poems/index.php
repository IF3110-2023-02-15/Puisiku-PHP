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