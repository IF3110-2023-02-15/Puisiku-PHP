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
        $_SESSION['profile_url'] = $user['image_path'];

        return SUCCESS;
    }

    public function getAllUsernames(){
        return $this->userModel->getAllUsernames();
    }

    // public function getIDUsernames(){
    //     return $this->userModel->getIDUsernames();
    // }

    public function getPaginatedUsers($offset, $perPage) {
        return $this->userModel->getIDUsernames($offset, $perPage);
    }

    public function getPageCount(){
        return $this->userModel->getPageCount();
    }

    public function readAll(){
        return $this->userModel->readAll();
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

    public function getData($id){
        $userModel = new UsersModel();
        $user = $userModel->findById($id);
        return $user;
    }

    public function update($id, $username, $description,  $imagePath = null) {
        $userModel = new UsersModel();

        try {
            $result = $userModel->update($id, $username, $description, $imagePath);

            // Update session data
            $_SESSION['username'] = $username;
            if ($imagePath) {
                $_SESSION['profile_url'] = $imagePath;
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

    public function updateRole($id) {
        $userModel = new UsersModel();

        try {
            $result = $userModel->updateRole($id);

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }
}
