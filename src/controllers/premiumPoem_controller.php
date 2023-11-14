<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'external/rest/index.php';

class PremiumPoem extends Controller
{
    public function poem($params)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
        }

        $poemId = $params['poemId'];
        $restService = new RestService();

        try {
            $current_page = 'Premium';
            $display_search = false;

            list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

            // Get album's poems
            $poem = json_decode($restService->call('GET', '/poem/' . $poemId));
            $creator = json_decode($restService->call('GET', '/user/creator/' . $poem->creatorId));

            $this->view('premiumPoem/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'poem' => $poem, 'creator' => $creator]);
        } catch (Exception $e) {
            $this->notFound();
        }
    }
}
