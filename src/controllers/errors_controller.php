<?php

require_once 'controller.php';

class Errors extends Controller {
    public function index($code = '404') {
        $this->view('errors/index', ['code' => $code]);
    }
}
