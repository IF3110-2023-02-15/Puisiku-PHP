<?php

require_once SERVICES_DIR . 'playlists/index.php';

class Controller {
    public function view($view, $data = []) {
        // Extract the data array to variables for use in the view
        extract($data);

        // Include the view file
        require_once PAGES_DIR . $view . '.php';
    }

    public function unauthorized() {
        $this->view('errors/index', ['code' => 401]);
    }

    public function notFound() {
        $this->view('errors/index', ['code' => 404]);
    }

    public function methodNotAllowed() {
        $this->view('errors/index', ['code' => 405]);
    }

    public function getSidebarNavbarInfo() {
        $role = $_SESSION['role'];
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/default_user.png';

        $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $playlistsService = new PlaylistsService();
        $playlists = $playlistsService->getUserPlaylists($userId);

        return [$role, $profile_url, json_encode($playlists)];
    }
}
