<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'external/rest/index.php';
require_once SERVICES_DIR . 'external/soap/index.php';

class Albums extends Controller
{
    public function index($params)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView($params);
                break;
            default:
                $this->methodNotAllowed();
        }
    }

    private function loadView($params)
    {
        $creatorId = $params['creatorId'];
        $restService = new RestService();

        try {
            $current_page = 'Premium';
            $display_search = false;

            list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

            // Get albums from REST
            $creatorData = json_decode($restService->call('GET', '/album/creator/' . $creatorId));

            $this->view('albums/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'creatorData' => $creatorData]);
        } catch (Exception $e) {
            $this->notFound();
        }
    }
}
