<?php

require_once 'controller.php';
require_once SRC_DIR . 'services/login/index.php';

class Login extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                $this->login();
                break;
            default:
                $this->loadPageNotFound();
                break;
        }
    }
    
    private function loadView() {
        $this->view('login/index');
    }

    private function login() {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $login_service = new LoginService();
            $result = $login_service->login($email, $password);


            $this->showNotification($result);
            header("Location: /dashboard");
            exit();
        } else {
            $this->showNotification('Please fill all the required fields!');
        }
    }
}

