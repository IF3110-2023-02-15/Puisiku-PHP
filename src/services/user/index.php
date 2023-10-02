<?php

require_once MODELS_DIR . 'users.php';

class UserService {
    public function login($email, $password) {
        $userModel = new UsersModel();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            return USER_NOT_FOUND;
        }

        $hashed_password = $user['hashed_password'];

        if (!$this->checkPassword($password, $hashed_password)) {
            return PASSWORD_INCORRECT;
        }

        // Check if there is session, if no, start
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Set session data
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        return SUCCESS;
    }

    public function register($username, $email, $password) {
        $userModel = new UsersModel();
        $user = $userModel->findByEmail($email);

        if ($user) {
            return EMAIL_ALREADY_EXISTED;
        }

        $hashed_password = $this->hashPassword($password);

        try {
            $userModel->create($username, $email, $hashed_password);
        } catch (PDOException $e) {
            return $e;
        }

        return SUCCESS;
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    private function checkPassword($password, $hashed_password) {
        return password_verify($password, $hashed_password);
    }

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getData($id){
        $userModel = new UsersModel();
        $user = $userModel->findById($id);
        return $user;
    }
}
