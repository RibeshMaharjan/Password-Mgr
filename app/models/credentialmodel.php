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
    private $password_history_table_name = "password_history";

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
            header("location: ../../public/index.php?error=CredentialAdded");
            exit();
        }
    }

    public function showCredential($site_id) {
        $stmt = $this->connect()->prepare("SELECT credentials.username, AES_DECRYPT(credentials.password,?) as password, credentials.notes, sites.site_name, sites.site_url FROM credentials INNER JOIN sites ON credentials.site_id = sites.site_id WHERE credentials.users_id = ? AND sites.site_id=?;");
        // $stmt = $this->connect()->prepare("SELECT *,AES_DECRYPT(password,?) as password FROM " . $this->table_name . " WHERE users_id = ? AND site_id = ?");
        
        if(!$stmt->execute(array($_SESSION["password"], $_SESSION["userid"], $site_id))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;   
    }

    public function showCredentialsUpdateHistory($id) {
        $stmt = $this->connect()->prepare("SELECT *,AES_DECRYPT(previous_password,?) as password FROM password_history WHERE account_id = ?");

        if(!$stmt->execute(array($_SESSION["password"], $id))) {
            $stmt = null;
            header("location: /../../public/index.php?error=Failed_to_retrieve_update_history");
            exit();
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function updateCredential($id, $site, $username, $password) {
        
        $accountInfo = $this->connect()->prepare("SELECT *,AES_DECRYPT(password,?) as password FROM " . $this->table_name . " WHERE account_id = ?;");
        
        if(!$accountInfo->execute(array($_SESSION["password"], $id))) {
            $accountInfo = null;
            header("location: ../index.php?error=old_password_retrievel_failed");
            exit();
        }

        $data = $accountInfo->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {
            $old_username = $row['username'];
            $old_password = $row['password'];
        }

        $updatestmt = $this->connect()->prepare("INSERT INTO password_history (account_id, previous_username, previous_password) VALUES (?,?,AES_ENCRYPT(?,?));");

        if(!$updatestmt->execute(array($id, $old_username, $old_password, $_SESSION["password"]))) {
            $updatestmt = null;
            header(header: "location: ../index.php?error=failed_to_insert_updated_password");
            exit();
        }
        
        $stmt = $this->connect()->prepare("UPDATE " . $this->table_name . " SET site = ?, username = ?, password = AES_ENCRYPT(?,?) WHERE account_id = ?;");
        
        if(!$stmt->execute(array($site, $username, $password, $_SESSION["password"], $id))) {
            $stmt = null;
            header("location: ../index.php?error=failed_to_update_password");
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