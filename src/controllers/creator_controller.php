<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once VIEWS_DIR . 'components/poems/index.php';
require_once SERVICES_DIR . 'file/index.php';
require_once VIEWS_DIR . 'components/table.php';

class Creator extends Controller {

    public function index($params) {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                $this->addPoem();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView(){
        $current_page = 'Creator';
        $display_search = false;

        $id=isset($_SESSION['id'])?($_SESSION['id']):null;

        $userService = new UserService();
        $data = $userService->getData($id);
        

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $this->view('creator/index', 
        ['current_page' => $current_page, 
        'playlists'=> $playlists, 'role' => $role, 
        'display_search' => $display_search, 
        'profile_url' => $profile_url, 
        'data' => $data,
        'id' =>$id]);
    }

    public function getPoemData($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        $poemId = $params['id'];

        $poemsService = new PoemsService();
        

        try {
            $result = $poemsService->searchById($poemId);
            echo json_encode(['success' => $result]);
        } catch  (Exception $e){
            echo json_encode(['error' => 'Error updating: ' . $e->getMessage()]);
        }

    }


    public function getPoems() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        $id=isset($_SESSION['id'])?($_SESSION['id']):null;

        header('Content-Type: application/json');

        $poemService = new PoemsService();

        $result = $poemService->getAllPoemByCreator($id);
        $poems = createTablePoem(['#', 'Title', 'Genre', 'Year', 'Delete', 'Update'], $result);


        echo json_encode($poems);
    }

    public function getModal() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $users = addPoemModal();
        echo json_encode($users);
    }

    public function addPoem(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $title = isset($_POST['add-poem-title']) ? $_POST['add-poem-title'] : null;
        $genre = isset($_POST['add-poem-genre']) ? $_POST['add-poem-genre'] : null;
        $content = isset($_POST['add-poem-content']) ? $_POST['add-poem-content'] : null;
        $image = isset($_FILES['add-poem-image']['tmp_name']) ? $_FILES['add-poem-image']['tmp_name'] : null;
        $audio = isset($_FILES['add-poem-audio']['tmp_name']) ? $_FILES['add-poem-audio']['tmp_name'] : null;;
        $year = isset($_POST['add-poem-year']) ? $_POST['add-poem-year'] : null;

        $imagePath = null;
        $audioPath = null;


        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['add-poem-image']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        if ($audio != null) {
            $fileService = new FileService();

            try {
                $audioPath = $fileService->upload($_FILES['add-poem-audio']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        // echo json_encode(["hai" => $imagePath, "tes" => $audioPath]);

        $poemService = new PoemsService();
        try {
            $result = $poemService->create($id, $title, $genre, $content, $imagePath, $audioPath, $year);
            echo json_encode(['success' => 'Poem add successfully', 'result' => $result]);
        } catch (Exception $e) {
            error_log('Error add poem: ' . $e->getMessage());
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

    }

    public function deletePoem($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $poemId = $params['id'];

        if ($poemId) {
            $poemService = new PoemsService();

            try {
                $result = $poemService->deletePoem($poemId);
                // Return a success response with HTTP status 200
                header('HTTP/1.1 200 OK');
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
            } catch (Exception $e) {
                // Handle any errors that may occur during deletion
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json');
                echo json_encode(['error' => $e]);
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid user ID']);
        }
    }

    public function updatePoem($params){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $poemId = $params['id'];

        $title = isset($_POST['title-update-poem-list']) ? $_POST['title-update-poem-list'] : null;
        $genre = isset($_POST['genre-update-poem-list']) ? $_POST['genre-update-poem-list'] : null;
        $content = isset($_POST['content-update-poem-list']) ? $_POST['content-update-poem-list'] : null;
        $image = isset($_FILES['image-update-poem-list']['tmp_name']) ? $_FILES['image-update-poem-list']['tmp_name'] : null;
        $audio = isset($_FILES['audio-update-poem-list']['tmp_name']) ? $_FILES['audio-update-poem-list']['tmp_name'] : null;


        $imagePath = null;
        $audioPath = null;

        $poemService = new PoemsService();

        // Try to upload file
        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['image-update-poem-list']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        if ($audio != null) {
            $fileService = new FileService();

            try {
                $audioPath = $fileService->upload($_FILES['audio-update-poem-list']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        
        try {
            $result = $poemService->update($poemId, $title, $genre, $content, $imagePath, $audioPath);
            echo json_encode(['success' => 'Poem updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }
    }
}