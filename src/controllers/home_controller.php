<?php

require_once 'controller.php';

class Home extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->view('home/index');
        }
    }
}