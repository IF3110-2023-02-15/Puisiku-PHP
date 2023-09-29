<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'user/index.php';

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
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView() {
        $this->view('register/index');
    }

    private function register() {
        // Set the content type to application/json
        header('Content-Type: application/json');

        // Check if all required fields are set
        if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["confirm_password"])) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Please fill in all the required fields!']);
            exit();
        }

        // Sanitize user input
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

        // Check if password and confirmation password match
        if ($password !== $confirm_password) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Password and confirmation password not matched!']);
            exit();
        }

        // Register the user
        $userService = new UserService();
        $registerResult = $userService->register($username, $email, $password);

        switch ($registerResult) {
            case 'SUCCESS':
                // Log this user in
                $loginResult = $userService->login($email,$password);

                if ($loginResult == 'SUCCESS') {
                    echo json_encode(['status' => 'SUCCESS', 'message' => 'Successfully registered user! Logged in!']);
                } else {
                    echo json_encode(['status' => 'ERROR', 'message' => 'Successfully registered user! Failed to log in!']);
                }
                break;
            case 'EMAIL_ALREADY_EXISTED':
                echo json_encode(['status' => 'ERROR', 'message' => 'Email already existed.']);
                break;
            default:
                echo json_encode(['status' => 'ERROR', 'message' => 'An error occurred during registration.']);
                break;
        }

        exit();
    }
}
