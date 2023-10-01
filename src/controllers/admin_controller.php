<?php

require_once 'controller.php';
require_once MODELS_DIR . 'users.php';
require_once MODELS_DIR . 'playlists.php';
require_once MODELS_DIR . 'poems.php';

class Admin extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->loadView();
        }
    }

    
    private function loadView() {
        $current_page = 'Admin';
        $playlists = [];
        $role = $_SESSION['role'];
        $display_search = false;
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/queencard.jpeg';

        $userModel = new User();
        $usernames = $userModel->getAllUsernames();

        $playlistsModel = new Playlist();
        $listofplaylist = $playlistsModel->getAllPlaylistName();

        $poemModel = new Poem();
        $poemtitles = $poemModel->getAllPoemsName();

    
        $this->view('admin/index',
        ['current_page' => $current_page, 
        'playlists'=> $playlists, 
        'role' => $role, 
        'display_search' => $display_search, 
        'profile_url' => $profile_url,
        'usernames' => $usernames,
        'listofplaylist' => $listofplaylist,
        'poemtitles' => $poemtitles]);
    }
}