<?php

require_once MODELS_DIR . 'users.php';

class UserService {
    private $userModel;

    public function __construct(){
        $this->userModel = new UsersModel();
    }
    public function login($email, $password) {
        $user = $this->userModel->findByEmail($email);

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

    public function getAllUsernames(){
        return $this->userModel->getAllUsernames();
    }

    public function getIDUsernames(){
        return $this->userModel->getIDUsernames();
    }

    public function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }

    public function register($username, $email, $password) {
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            return EMAIL_ALREADY_EXISTED;
        }

        $hashed_password = $this->hashPassword($password);

        try {
            $this->userModel->create($username, $email, $hashed_password);
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
}
