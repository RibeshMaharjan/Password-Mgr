<!-- Db Connection File -->
<?php

class Dbh {

    public $dbParams;
    public function __construct() {
        require_once __DIR__.'/config/database.php';
        $this->dbParams = $dbParams = array(
            'servername' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'passwordmgr'
        );
    }

    public function connect() {
        try {
            $dbParams = array(
                'servername' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'passwordmgr'
            );
            $dbh = new PDO("mysql:host=".$dbParams['servername'].";dbname=".$dbParams['dbname']."" ,  $dbParams['username'],  $dbParams['password']);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }
}