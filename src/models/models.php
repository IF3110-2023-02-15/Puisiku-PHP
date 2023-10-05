<?php

require_once SRC_DIR . 'database/psql.php';

class Models {
    protected $db;

    public function __construct() {
        $this->db = new PSQL();
    }
}