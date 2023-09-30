<?php

require_once 'controller.php';

class Landing extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->view('landing/index');
        }
    }
}