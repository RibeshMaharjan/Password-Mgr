<?php

session_start();
include_once 'dbh.php';
include_once '../lib/aes.php';

if (isset($_POST["update"])) {
    echo "update";
    $user_id = $_SESSION["userid"];
    $site_id = $_POST["site_id"];
    $id = $_POST["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    $aes = new AES();

    $encypted_pwd = $aes->encrypt($password, $_SESSION["password"]);
    // Updateing the credential
    $accountInfo = $dbh->prepare("SELECT * FROM credentials WHERE account_id = ?;");
    $accountInfo->execute(array($id));

    if ($accountInfo->rowCount() > 0) {
        $data = $accountInfo->fetch(PDO::FETCH_ASSOC);
        $old_username = $data['username'];
        $old_password = $data['password'];

        $updatestmt = $dbh->prepare("INSERT INTO password_history (account_id, previous_username, previous_password) VALUES (?,?,?);");
        $updatestmt->execute(array($id, $old_username, $old_password));

        $stmt = $dbh->prepare("UPDATE credentials SET notes = ?, username = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE account_id = ?;");
        $stmt->execute(array($notes, $username, $encypted_pwd, $id));

        header("location: ../single.php?id=$site_id");
        // } else {
        //     echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">No credential found.</div>';
        // }
    }
}

if (isset($_POST["delete"])) {
    echo "delete";
    $account_id = $_POST["id"];
    echo $account_id;
}

if (isset($_POST["add"])) {
    echo "add";
}
