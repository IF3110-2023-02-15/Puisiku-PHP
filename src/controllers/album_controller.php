<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'external/rest/index.php';

class Album extends Controller
{
    public function album($params)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
        }

        $albumId = $params['albumId'];
        $restService = new RestService();

        try {
            $current_page = 'Premium';
            $display_search = false;

            list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

            // Get album's poems
            $album = json_decode($restService->call('GET', '/album/' . $albumId));
            $poems = json_decode($restService->call('GET', '/poem/album/' . $albumId));

            $this->view('album/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'album' => $album, 'poems' => $poems]);
        } catch (Exception $e) {
            $this->notFound();
        }
    }
}
