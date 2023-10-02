<?php

require_once 'controller.php';
require_once MODELS_DIR . 'users.php';
require_once MODELS_DIR . 'playlists.php';
require_once MODELS_DIR . 'poems.php';
require_once SERVICES_DIR . 'user/index.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'playlist/index.php';
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

        $current_page = 'Home';
        $playlists = [];
        $role = $_SESSION['role'];
        $display_search = false;
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/queencard.jpeg';

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

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $userId = $_GET['id'];

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

    public function getPoems() {
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

    public function deletePoem() {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $poemId = $_GET['id'];

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

    public function getPlaylists() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $playlistService = new PlaylistService();
        $result = $playlistService->getIDPlaylistName();
        $playlist = adminBox1($result);

        echo json_encode($playlist);
    }

    public function deletePlaylist() {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $this->methodNotAllowed();
            return;
        }

        $playlistId = $_GET['id'];

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


    
}