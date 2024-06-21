<?php

require_once __DIR__.'/../dbh.php';
class Model extends Dbh{

    function __construct() {
        $dbh = new Dbh();
        if ($dbh) {
            $this->connection = $dbh->connect();
        } else {
            throw new Exception('Failed to instantiate Dbh class.');
        }
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