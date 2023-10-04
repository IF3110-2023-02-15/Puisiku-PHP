<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once VIEWS_DIR . 'components/poems/index.php';
require_once VIEWS_DIR . 'components/pagination.php';

class Poems extends Controller {
    public function index($method = null) {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    public function loadView() {
        $current_page = 'Poems';
        $playlists = [];
        $role = $_SESSION['role'];
        $display_search = true;
        $profile_url = isset($_SESSION['profile_url']) ? $_SESSION['profile_url'] : '/img/queencard.jpeg';

        $this->view('poems/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url]);
    }

    public function search() {
        try {
            if ($_SERVER['REQUEST_METHOD'] != 'GET') {
                $this->methodNotAllowed();
                return;
            }

            header('Content-Type: application/json');

            $searchKey = isset($_GET['search_query']) ? $_GET['search_query'] : null;
            $genre = isset($_GET['genre']) ? json_decode($_GET['genre']) : null;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $year_query = isset($_GET['year_query']) ? json_decode($_GET['year_query']) : null;
            $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'Poems.created_at DESC';

            $poemsService = new PoemsService();
            $results = $poemsService->search($searchKey, $genre, $year_query, $sort_by, $page);
            $totalPages = $results['total_pages'];

            $poems = poems($results['poems']);
            $pagination = pagination($totalPages > 0 ? $page : 0 , $totalPages);

            // Put the poems and pagination into an associative array
            $response = [
                'poems' => $poems,
                'pagination' => $pagination
            ];

            // Convert the array to a JSON string and echo it
            echo json_encode($response);
        } catch (Exception $e) {
            // Handle the exception
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function recommendation() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }


    }
}