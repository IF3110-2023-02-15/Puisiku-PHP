<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'poems/index.php';

class Poem extends Controller {

    public function index($params) {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView($params);
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView($params) {
        $id = $params['id'];

        $poemsService = new PoemsService();
        $result = $poemsService->searchById($id);

        if ($result == 'POEM_NOT_FOUND') {
            $this->view('errors/index', ['code' => 404]);
        } else {
            $this->view('poem/index', ['data' => $result]);
        }
    }

    private function loadAddPoemView(){
        $this->view('poem/poem_form');
    }
}