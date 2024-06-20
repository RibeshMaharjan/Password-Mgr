<?php

require_once __DIR__.'/../dbh.php';
class Model extends Dbh{

    protected $connection;

    protected function __construct() {
        $this->connection = $this->connect();
    }

    // function create($tableName,$insertWhat){

    // }

	// function read($tableName,$args,$whereArgs){

    // }

    // function update($tableName,$whatToSet,$whereArgs){

    // }

    // function delete($tableName,$whereArgs){

    // }

    // function where($sql,$whereArgs){

    // }
}