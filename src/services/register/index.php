<?php

require_once MODELS_DIR . 'users.php';

class RegisterService {
    public function register($username, $email, $password) {
        $userModel = new User();
        $user = $userModel->read_by_email($email);
    
        if ($user) {
            return USER_ALREADY_EXISTS;
        }

        $hashed_password = $this->hashPassword($password);
    
        try {
            $userModel->create($username, $email, $hashed_password);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return EMAIL_ALREADY_EXISTED;
            } else {
                return $e;
            }
        }
        
        return SUCCESS;
    }

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }   
}
