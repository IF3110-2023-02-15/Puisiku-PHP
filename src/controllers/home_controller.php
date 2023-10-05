<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'playlists/index.php';

class Home extends Controller {
    public function index() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView() {
        $current_page = 'Home';
        $display_search = false;

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $this->view('home/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url]);
    }
}