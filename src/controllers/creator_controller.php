<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once VIEWS_DIR . 'components/poems/index.php';

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
        $userService=new UserService();
        $data= $userService->getData($id);

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $this->view('creator/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'data' => $data]);
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

        $poemService = new PoemsService();
        try {
            $result = $poemService->create($id, $title, $genre, $content, $imagePath, $audioPath, $year);
            echo json_encode(['success' => 'Poem add successfully', 'result' => $result]);
        } catch (Exception $e) {
            error_log('Error add poem: ' . $e->getMessage());
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

    }
}