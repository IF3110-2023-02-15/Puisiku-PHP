<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';
require_once SERVICES_DIR . 'user/index.php';
require_once VIEWS_DIR . 'components/poems/index.php';

class Creator extends Controller {

    public function index($params) {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView(){
        $current_page = 'Creator';
        $display_search = false;

        $id=isset($_SESSION['id'])?($_SESSION['id']):null;
        $userService=new UserService();
        $data= $userService->getData($id);

        list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

        $this->view('creator/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'data' => $data]);
    }

    public function getModal() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $this->methodNotAllowed();
            return;
        }

        header('Content-Type: application/json');

        $users = addPoemModal();
        echo json_encode($users);
    }
}