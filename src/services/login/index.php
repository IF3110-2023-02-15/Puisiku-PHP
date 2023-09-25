<?php

require_once MODELS_DIR . 'users.php';

class LoginService {
    public function login($email, $password) {
        $userModel = new User();
        $user = $userModel->read_by_email($email);

        if (!$user) {
            return USER_NOT_FOUND;
        }

        $hashed_password = $user['hashed_password'];

        $isPasswordCorrect = $this->checkPassword($password, $hashed_password);

        if (!$isPasswordCorrect) {
            return PASSWORD_INCORRECT;
        }
        
        return SUCCESS;
    }

    private function checkPassword($password, $hashed_password) {
        return password_verify($password, $hashed_password);
    }
}