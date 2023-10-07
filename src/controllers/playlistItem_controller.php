<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'playlists/index.php';
require_once VIEWS_DIR . 'components/table.php';

class PlaylistItem extends Controller {

    public function index() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->add();
                break;
            case 'DELETE':
                $this->delete();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function add() {
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

    private function delete() {
        $data = $this->getData();

        $playlistId = $data['playlistId'];
        $poemId = $data['poemId'];

        $playlistsService = new PlaylistsService();

        try {
            $result = $playlistsService->deletePlaylistItem($playlistId, $poemId);
            $playlists = $playlistsService->getPlaylistItems($playlistId);

            $table = createTable(['#', 'Title', 'Creator', 'Genre', 'Year', 'Delete'], $playlists);

            echo json_encode(['success' => $result, 'table' => $table]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}