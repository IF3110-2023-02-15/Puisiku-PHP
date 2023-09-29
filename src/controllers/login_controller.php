<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'user/index.php';

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
                $this->methodNotAllowed();
                break;
        }
    }
    
    private function loadView() {
        $this->view('login/index');
    }

    private function login() {
        // Set the content type to application/json
        header('Content-Type: application/json');

        // Check if all required fields are set
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Please fill all the required fields!']);
            exit();
        }

        // Sanitize user input
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Attempt to log in
        $login_service = new UserService();
        $result = $login_service->login($email, $password);

        switch ($result) {
            case SUCCESS:
                echo json_encode(['status' => 'SUCCESS', 'message' => 'Login success!']);
                break;
            case 'USER_NOT_FOUND':
                echo json_encode(['status' => 'ERROR', 'message' => 'User not found. Please check your email.']);
                break;
            case 'PASSWORD_INCORRECT':
                echo json_encode(['status' => 'ERROR', 'message' => 'Incorrect password. Please check your password.']);
                break;
            default:
                echo json_encode(['status' => 'ERROR', 'message' => $result]);
                break;
        }

        exit();
    }
}

