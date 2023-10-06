<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'playlists/index.php';

class Poem extends Controller {

    public function index($params) {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView($params);
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView($params) {
        $userId = $_SESSION['id'];
        $id = $params['id'];

        $poemsService = new PoemsService();
        $result = $poemsService->searchById($id);

        $playlistsService = new PlaylistsService();
        $playlists = $playlistsService->getUserPlaylists($userId);

        if ($result == 'POEM_NOT_FOUND') {
            $this->view('errors/index', ['code' => 404]);
        } else {
            $this->view('poem/index', ['data' => $result, 'playlists' => $playlists]);
        }
    }

    private function loadAddPoemView(){
        $this->view('poem/poem_form');
    }
}