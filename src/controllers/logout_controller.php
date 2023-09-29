<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'user/index.php';

class Logout extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->logout();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function logout() {
        $userService = new UserService();
        $userService->logout();

        header('Location: /');
        exit();
    }
}
