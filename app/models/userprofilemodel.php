<?php

require_once __DIR__.'/../core/model.php';
if (!isset($_SESSION)) {
    session_start();
}
class UserProfileModel extends Model {
    
    private  $conn;

    function __construct() {
        global $dbh;

        $this->conn = $dbh;
    }
    
    public function getUserById($user_id){
        $saltkey = $_SESSION["password"];
        $stmt = $this->conn->prepare("SELECT *,AES_DECRYPT(users_pwd, :salt_key) AS decrypted_password FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':salt_key', $_SESSION["password"]);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $userInfo;
    }
    
    public function updateUserById($id, $username, $email, $password, $key) {
        $stmt = $this->conn->prepare("UPDATE users SET 
                                                        users_name = :username,
                                                        users_email = :email,
                                                        users_pwd = AES_ENCRYPT(:pwd,:salt)
                                                        WHERE user_id = :user_id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $password);
        $stmt->bindParam(':salt', $_SESSION["password"]);
        $stmt->bindParam(':user_id', $id);
    
        $stmt->execute();        
    }
}