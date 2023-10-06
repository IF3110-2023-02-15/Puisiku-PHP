<?php

require_once SERVICES_DIR . 'playlists/index.php';

class Controller {
    protected function view($view, $data = []) {
        // Extract the data array to variables for use in the view
        extract($data);

        // Include the view file
        require_once PAGES_DIR . $view . '.php';
    }

    protected function unauthorized() {
        $this->view('errors/index', ['code' => 401]);
    }

    protected function notFound() {
        $this->view('errors/index', ['code' => 404]);
    }

    protected function methodNotAllowed() {
        $this->view('errors/index', ['code' => 405]);
    }

    protected function getSidebarNavbarInfo() {
        $role = $_SESSION['role'];
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/default_user.png';

        $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $playlistsService = new PlaylistsService();
        $playlists = $playlistsService->getUserPlaylists($userId);

        return [$role, $profile_url, json_encode($playlists)];
    }

    protected function getData() {
        $json_str = file_get_contents('php://input');
        return json_decode($json_str, true);
    }
}
