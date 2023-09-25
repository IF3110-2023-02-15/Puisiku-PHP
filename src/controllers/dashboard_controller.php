<?php

require_once 'controller.php';

class Dashboard extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->view('dashboard/index');
        }
    }
}