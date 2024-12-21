<?php

require_once __DIR__.'/../dbh.php';
class Model{

    private $conn;
    function __construct() {
        global $dbh;
        $this->conn = $dbh;
    }
}