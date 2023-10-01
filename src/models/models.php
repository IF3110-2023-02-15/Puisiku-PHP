<?php

class Models {
    protected $db;

    public function __construct() {
        $this->db = new PSQL();
    }
}