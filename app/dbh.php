<!-- Db Connection File -->
<?php
class Dbh {

    private $dbParams;
    function __construct() {
        require_once __DIR__.'/config/database.php';
        $this->dbParams = $dbParams;
    }

    protected function connect() {
        try {
            $dbh = new PDO('mysql:host=locahost;dbname=passwordmgr' ,  $username,  $this->dbParams['password']);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }
}