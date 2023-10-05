<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'playlists/index.php';

class Playlist extends Controller {

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
        $playlistId = $_GET['id'];

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
}