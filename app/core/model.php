<?php

require_once __DIR__.'/../dbh.php';
class Model extends Dbh{

    private $connection;
    function __construct() {
        $dbh = new Dbh();
        if ($dbh) {
            $this->connection = $dbh->connect();
        } else {
            throw new Exception('Failed to instantiate Dbh class.');
        }
    }
}