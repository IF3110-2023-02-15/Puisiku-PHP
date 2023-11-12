<?php

require_once 'controller.php';
require_once MODELS_DIR . 'users.php';
require_once MODELS_DIR . 'playlists.php';
require_once MODELS_DIR . 'poems.php';
require_once SERVICES_DIR . 'user/index.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'playlists/index.php';
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

    public function getUserData($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        $id = $params['id'];

        $userService = new UserService();
        

        try {
            $result = $userService->getData($id);
            echo json_encode(['success' => $result]);
        } catch  (Exception $e){
            echo json_encode(['error' => 'Error updating: ' . $e->getMessage()]);
        }
    }

    public function getPlaylistData($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        $id = $params['id'];

        $playlistService = new PlaylistsService();
        

        try {
            $result = $playlistService->getPlaylistData($id);
            echo json_encode(['success' => $result]);
        } catch  (Exception $e){
            echo json_encode(['error' => 'Error updating: ' . $e->getMessage()]);
        }
    }

    public function getUsers() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $userpage = isset($_GET['userpage']) ? (int)$_GET['userpage'] : 1;
        $perPage = isset($_GET['usersPerPage']) ? (int)$_GET['usersPerPage'] : 20;

        $page = $userpage > 0 ? $userpage : 1;
        $perPage = ($perPage > 0 && $perPage <= 100) ? $perPage : 20;

        $offset = ($page - 1) * $perPage;

        $userService = new UserService();
        $result = $userService->getPaginatedUsers($offset, $perPage);

        $users = adminBox2($result, $offset);
        $rowCount = $userService->getPageCount();

        $pageCountUser = ceil($rowCount['count'] / $perPage);

        echo json_encode(['users' => $users, 'pageCountUser' => $pageCountUser]);
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

    public function updateUser($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $userId = $params['id'];

        $data = $this->getData();
        $username = isset($data['update-username']) ? $data['update-username'] : null;
        $description = isset($data['update-description']) ? $data['update-description'] : null;
        $imagePath = isset($data['update-user-image-path']) ? $data['update-user-image-path'] : null;


        $userService = new UserService();

        
        try {
            $result = $userService->update($userId, $username, $description, $imagePath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }
    }

    public function getPoems($params) {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $poempage = isset($_GET['poempage']) ? (int)$_GET['poempage'] : 1;
        $perPage = isset($_GET['poemsPerPage']) ? (int)$_GET['poemsPerPage'] : 20;

        $page = $poempage > 0 ? $poempage : 1;
        $perPage = ($perPage > 0 && $perPage <= 100) ? $perPage : 20;

        $offset = ($page - 1) * $perPage;

        $poemService = new PoemsService();
        $result = $poemService->getPaginatedPoems($offset, $perPage);
        $poems = adminBox1($result, $offset);

        $rowCount = $poemService->getPageCount();

        $pageCountPoem = ceil($rowCount['count'] / $perPage);

        echo json_encode(['poems' => $poems, 'pageCountPoem' => $pageCountPoem]);
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
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $poemId = $params['id'];

        $data = $this->getData();
        $title = isset($data['title-update-poem']) ? $data['title-update-poem'] : null;
        $genre = isset($data['genre-update-poem']) ? $data['genre-update-poem'] : null;
        $content = isset($data['content-update-poem']) ? $data['content-update-poem'] : null;
        $imagePath = isset($data['update-poem-admin-image-path']) ? $data['update-poem-admin-image-path'] : null;
        $audioPath = isset($data['update-poem-admin-audio-path']) ? $data['update-poem-admin-audio-path'] : null;

        $poemService = new PoemsService();

        
        try {
            $result = $poemService->update($poemId, $title, $genre, $content, $imagePath, $audioPath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }

    }

    public function getPlaylists() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $playlistService = new PlaylistsService();
        $result = $playlistService->getIDPlaylistName();
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
            $playlistService = new PlaylistsService();

            try {
                $result = $playlistService->deletePlaylist($playlistId);
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

    public function updatePlaylist($params){
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $playlistId = $params['id'];


        $data = $this->getData();
        $title = isset($data['title-update-playlist']) ? $data['title-update-playlist'] : null;
        $imagePath = isset($data['update-playlist-image-path']) ? $data['update-playlist-image-path'] : null;


        $playlistService = new PlaylistsService();

       
        try {
            $result = $playlistService->update($playlistId, $title, $imagePath=null);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }
    }

    
}