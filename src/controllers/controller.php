<?php

class Controller {
    public function view($view, $data = []) {
        // Extract the data array to variables for use in the view
        extract($data);

        // Include the view file
        require_once PAGES_DIR . $view . '.php';
    }

    public function methodNotAllowed() {
        $this->view('errors/index', ['code' => 405]);
    }
}
