<?php

require_once MODELS_DIR . 'users.php';

class RegisterService {
    public function register($username, $email, $password) {
        $userModel = new User();
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

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }   
}
