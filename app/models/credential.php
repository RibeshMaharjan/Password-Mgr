<?php

// require_once '../config/dbh.php';
if (!isset($_SESSION)) {
    session_start();
}

class Credential extends Dbh{
    private $conn;
    private $table_name = "credentials";

    protected function createCredential($user_id, $site, $username, $password) {
        $stmt = $this->connect()->prepare('SELECT users_salt FROM users WHERE users_id = ?');
        
        if(!$stmt->execute(array($user_id))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate Salt key
        $salt = $_SESSION["password"];

        $stmt = $this->connect()->prepare("INSERT INTO ".$this->table_name." (users_id, site, username, password) VALUES (?,?,?,AES_ENCRYPT(?,?));");
        
        if(!$stmt->execute(array($user_id, $site, $username, $password, $salt))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        else {
            $stmt = null;
            header("location: ../index.php?error=CredentialAdded");
            exit();
        }
    }

    protected function showCredential() {
        $stmt = $this->connect()->prepare("SELECT site,username,AES_DECRYPT(password,?) as password FROM " . $this->table_name . " WHERE users_id = ?;");

        if(!$stmt->execute(array($_SESSION["password"], $_SESSION["userid"]))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        
        // $data = $stml->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;
    }
}