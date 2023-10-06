<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'playlists/index.php';

class PlaylistItem extends Controller {

    public function index() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->add();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    public function add() {
        $playlistId = isset($_POST['playlistId']) ? $_POST['playlistId'] : null;
        $poemId = isset($_POST['poemId']) ? $_POST['poemId'] : null;

        $playlistsService = new PlaylistsService();

        try {
            $result = $playlistsService->addPlaylistItem($playlistId, $poemId);

            echo json_encode(['success' => 'Successfully added poem to playlist!', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}