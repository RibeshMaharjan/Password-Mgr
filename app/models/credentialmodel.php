<?php

require_once __DIR__.'/../core/model.php';
if (!isset($_SESSION)) {
    session_start();
}

class CredentialModel extends Model{

    function __construct(){
		parent::__construct();
		// echo 'Test Model  CREATED new changes'."<br />";
	}

    function sayHello($name){
		echo "Welcome to  ". $name;
	}
    private $conn;
    private $table_name = "credentials";

    public function createCredential($user_id, $site, $username, $password) {
        $salt = $_SESSION["password"];

        $stmt = $this->connect()->prepare("INSERT INTO ".$this->table_name." (users_id, site, username, password) VALUES (?,?,?,AES_ENCRYPT(?,?));");
        
        if(!$stmt->execute(array($user_id, $site, $username, $password, $salt))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        else {
            $stmt = null;
            header("location: /../public/index.php?error=CredentialAdded");
            exit();
        }
    }

    public function showCredential() {
        $stmt = $this->connect()->prepare("SELECT *,AES_DECRYPT(password,?) as password FROM " . $this->table_name . " WHERE users_id = ?;");

        if(!$stmt->execute(array($_SESSION["password"], $_SESSION["userid"]))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;   
    }

    public function updateCredential($id, $site, $username, $password) {
        $stmt = $this->connect()->prepare("UPDATE " . $this->table_name . " SET site = ?, username = ?, password = AES_ENCRYPT(?,?) WHERE account_id = ?;");

        if(!$stmt->execute(array($site, $username, $password, $_SESSION["password"], $id))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
    }
    public function deleteCredential($id) {
        $stmt = $this->connect()->prepare("DELETE FROM " . $this->table_name . " WHERE account_id = ?;");

        if(!$stmt->execute(array($id))) {
            $stmt = null;
            header("location: /../../public/index.php?error=stmtfailed");
            exit();
        }
    }
}