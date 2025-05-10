<?php

session_start();
include_once 'dbh.php';
include_once '../lib/aes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["userid"];
    $id = $_POST["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    $aes = new AES();

    $encypted_pwd = $aes->encrypt($password, $_SESSION["password"]);
    // Updateing the credential
    // $accountInfo = $dbh->prepare("SELECT * FROM credentials WHERE account_id = ?;");
    // $accountInfo->execute($id);

    // if($accountInfo->rowCount() > 0) {
    //     $data = $accountInfo->fetch(PDO::FETCH_ASSOC);
    //     $old_username = $data['username'];
    //     $old_password = $data['password'];

        // $updatestmt = $dbh->prepare("INSERT INTO password_history (account_id, previous_username, previous_password) VALUES (?,?,AES_ENCRYPT(?,?));");
        // $updatestmt->execute(array($id, $old_username, $old_password, $_SESSION["password"]));

        $stmt = $dbh->prepare("UPDATE credentials SET notes = ?, username = ?, password = ? WHERE account_id = ?;");
        $stmt->execute(array($notes, $username, $encypted_pwd, $id));

        header("location: ../single.php?site_id=");
    // } else {
    //     echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">No credential found.</div>';
    // }
}
