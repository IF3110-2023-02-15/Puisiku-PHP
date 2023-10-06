<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'playlists/index.php';
require_once SERVICES_DIR . 'file/index.php';

class Playlist extends Controller {

    public function index($params) {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView($params);
                break;
            case 'POST':
                $this->add();
                break;
            case 'PUT':
                $this->update($params);
                break;
            case 'DELETE':
                $this->delete($params);
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView($params) {
        $playlistId = $params['id'];

        $current_page = $playlistId;
        $display_search = false;

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $playlistsService = new PlaylistsService();

        try {
            $data = $playlistsService->getPlaylist($playlistId);
            $this->view('playlist/index', [
                'current_page' => $current_page,
                'playlists'=> $playlists,
                'role' => $role,
                'display_search' => $display_search,
                'profile_url' => $profile_url,
                'data' => $data
            ]);
        } catch (Exception $e) {
            $this->notFound();
        }
    }

    private function add() {
        $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $playlistTitle = isset($_POST['playlist-title']) ? $_POST['playlist-title'] : null;
        $playlistImage = isset($_FILES['playlist-image']['tmp_name']) ? $_FILES['playlist-image']['tmp_name'] : null;

        $imagePath = null;

        // Try to upload file
        if ($playlistImage != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['playlist-image']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        header('Content-Type: application/json');
        $playlistService = new PlaylistsService();

        try {
            $result = $playlistService->addPlaylist($userId, $playlistTitle, $imagePath);
            echo json_encode([
                'success' => 'Successfully added new playlist!',
                'result' => $result
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'An error has occurred: ' . $e]);
        }
    }

    private function update($params) {
        $_PUT = $this->getData();

        $playlistId = isset($params['id']) ? filter_var($params['id'], FILTER_SANITIZE_STRING) : null;
        $playlistTitle = isset($_PUT['playlist-title']) ? filter_var($_PUT['playlist-title'], FILTER_SANITIZE_STRING) : null;
        $playlistImage = isset($_PUT['playlist-image']) ? filter_var($_PUT['playlist-image'], FILTER_SANITIZE_URL) : null;

        $playlistsService = new PlaylistsService();

        try {
            $result = $playlistsService->update($playlistId, $playlistTitle, $playlistImage);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e]);
        }
    }

    private function delete($params) {
        $playlistId = isset($params['id']) ? filter_var($params['id'], FILTER_SANITIZE_STRING) : null;

        $playlistsService = new PlaylistsService();

        try {
            $result = $playlistsService->deletePlaylist($playlistId);
            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e]);
        }
    }
}