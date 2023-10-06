<?php

require_once 'controller.php';
require_once MODELS_DIR . 'users.php';
require_once MODELS_DIR . 'playlists.php';
require_once MODELS_DIR . 'poems.php';
require_once SERVICES_DIR . 'user/index.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'playlist/index.php';
require_once SERVICES_DIR . 'file/index.php';
require_once VIEWS_DIR . 'components/users/index.php';

class Admin extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                break;
            case 'DELETE':
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }
    
    public function loadView() {
        $current_page = 'Admin';
        $display_search = false;

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $this->view('admin/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url]);
    }

    public function getUsers() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $userService = new UserService();
        $result = $userService->getIDUsernames();

        $users = adminBox2($result);
        echo json_encode($users);
    }

    public function deleteUser($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $userId = $params['id'];


        if ($userId) {
            $userService = new UserService();

            try {
                $result = $userService->deleteUser($userId);
                // Return a success response with HTTP status 200

                header('HTTP/1.1 200 OK');
                header('Content-Type: application/json');
                echo json_encode(['message' => $result]);
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

    public function updateUser($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $userId = $params['id'];

        $username = isset($_POST['update-username']) ? $_POST['update-username'] : null;
        $description = isset($_POST['update-description']) ? $_POST['update-description'] : null;
        $image = isset($_FILES['update-image']['tmp_name']) ? $_FILES['update-image']['tmp_name'] : null;


        $imagePath = null;

        $userService = new UserService();

        if (isset($_POST['update-role'])) {
            $result = $userService->updateRole($userId);
        }

        // Try to upload file
        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['update-image']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        
        try {
            $result = $userService->update($userId, $username, $description, $imagePath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

        echo json_encode($userId);
    }

    public function getPoems($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $poemService = new PoemsService();
        $result = $poemService->getIDPoemName();
        $poems = adminBox1($result);


        echo json_encode($poems);
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
                echo json_encode(['message' => $result]);
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

        $title = isset($_POST['title-update-poem']) ? $_POST['title-update-poem'] : null;
        $genre = isset($_POST['genre-update-poem']) ? $_POST['genre-update-poem'] : null;
        $content = isset($_POST['content-update-poem']) ? $_POST['content-update-poem'] : null;
        $image = isset($_FILES['image-update-poem']['tmp_name']) ? $_FILES['image-update-poem']['tmp_name'] : null;
        $audio = isset($_FILES['audio-update-poem']['tmp_name']) ? $_FILES['audio-update-poem']['tmp_name'] : null;


        $imagePath = null;
        $audioPath = null;

        $poemService = new PoemsService();

        // Try to upload file
        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['image-update-poem']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        if ($audio != null) {
            $fileService = new FileService();

            try {
                $audioPath = $fileService->upload($_FILES['audio-update-poem']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        
        try {
            $result = $poemService->update($poemId, $title, $genre, $content, $imagePath, $audioPath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

        echo json_encode($poemId);
    }

    public function getPlaylists() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $playlistService = new PlaylistService();
        $result = $playlistService->getIDStatusPlaylistName();
        $playlist = adminBox3($result);

        echo json_encode($playlist);
    }

    public function deletePlaylist($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $playlistId = $params['id'];

        if ($playlistId) {
            $playlistService = new PlaylistService();

            try {
                $result = $playlistService->deletePlaylist($playlistId);
                // Return a success response with HTTP status 200
                header('HTTP/1.1 200 OK');
                header('Content-Type: application/json');
                echo json_encode(['message' => $result]);
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

    public function updatePlaylist($params){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $playlistId = $params['id'];

        $title = isset($_POST['title-update-playlist']) ? $_POST['title-update-playlist'] : null;
        $image = isset($_FILES['image-update-playlist']['tmp_name']) ? $_FILES['image-update-playlist']['tmp_name'] : null;

        $imagePath = null;

        $playlistService = new PlaylistService();

       
        // Try to upload file
        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['image-update-playlist']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }
        
        try {
            $result = $playlistService->update($playlistId, $title, $imagePath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

        echo json_encode($playlistId);
    }

    
}