<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'register/index.php';
require_once SERVICES_DIR . 'login/index.php';

class Register extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                $this->register();
                break;
            default:
                $this->loadPageNotFound();
                break;
        }
    }

    private function loadView() {
        $this->view('register/index');
    }

    private function register() {
        if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $confirm_password = trim($_POST["confirm_password"]);
    
            if ($password !== $confirm_password) {
                $this->showNotification("PASSWORD NOT MATCHED");
            }

            $registerService = new RegisterService();
            $registerResult = $registerService->register($username, $email, $password);

            $this->showNotification($registerResult);   

            if ($registerResult == 'SUCCESS') {
                // Log this user in
                $loginService = new LoginService();
                $loginResult = $loginService->login($email,$password);

                header('Location: /dashboard');
                $this->showNotification($loginResult);
            } else {
                // Redirect to Register
            }
        } else {
            $this->showNotification("Please fill in all the required fields!");
        }
    }
}
