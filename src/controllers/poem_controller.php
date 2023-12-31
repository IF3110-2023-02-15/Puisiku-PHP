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
        $id = $params['id'];

        $current_page = 'Poems';
        $display_search = false;

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $poemsService = new PoemsService();
        $result = $poemsService->searchById($id);

        if ($result == 'POEM_NOT_FOUND') {
            $this->view('errors/index', ['code' => 404]);
        } else {
            $this->view('poem/index', ['data' => $result, 'current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url]);
        }
    }

    private function loadAddPoemView(){
        $this->view('poem/poem_form');
    }
}