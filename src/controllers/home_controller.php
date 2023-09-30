<?php

require_once 'controller.php';

class Home extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->loadView();
        }
    }

    private function loadView() {
        $current_page = 'Dashboard';
        $playlists = [];
        $role = $_SESSION['role'];
        $display_search = false;
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/queencard.jpeg';

        $this->view('home/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url]);
    }
}