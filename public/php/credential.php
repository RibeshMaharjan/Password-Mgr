<?php

session_start();
include_once 'dbh.php';
include_once '../lib/aes.php';
$aes = new AES();

if (isset($_POST["update_credential"])) {
    $user_id = $_SESSION["userid"];
    $id = $_POST["id"];
    $site_id = $_POST["site_id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    $encypted_pwd = $aes->encrypt($password, $_SESSION["password"]);
    // Updating the credential
    $accountInfo = $dbh->prepare("SELECT * FROM credentials WHERE account_id = ? AND users_id = ?;");
    $accountInfo->execute(array($id, $user_id));

    if ($accountInfo->rowCount() > 0) {
        $data = $accountInfo->fetch(PDO::FETCH_ASSOC);
        $old_username = $data['username'];
        $old_password = $data['password'];

        try {
            $dbh->beginTransaction();
            if($old_password != $encypted_pwd){
                $updatestmt = $dbh->prepare("INSERT INTO password_history (account_id, previous_username, previous_password) VALUES (?,?,?);");
                $updatestmt->execute(array($id, $old_username, $old_password));
            }

            $stmt = $dbh->prepare("UPDATE credentials SET notes = ?, username = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE account_id = ?;");
            $stmt->execute(array($notes, $username, $encypted_pwd, $id));
            $_SESSION['success'] = 'Credential updated successfully.';
            $dbh->commit();
            header("location: ../single.php?id=$site_id");
            exit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo "Error: " . $e->getMessage();
            $_SESSION['error'] = 'Credential could not be updated. Please try again.';
            if (isset($_SESSION['site_id']) && $_SESSION['site_id'] != ''){
                header("location: ../single.php?id=" . $_SESSION['site_id']);
                exit();
            }
            header("location: ../dashboard.php");
            exit();
        }
    }
}

if (isset($_POST["delete_credential"])) {
    $id = $_POST["id"];
    $user_id = $_SESSION["userid"];
    $site_id = $_POST["site_id"];
    $accountInfo = $dbh->prepare("SELECT * FROM credentials WHERE account_id = ? AND users_id = ?;");
    $accountInfo->execute(array($id, $user_id));

    if ($accountInfo->rowCount() > 0) {
        $stmt = $dbh->prepare("DELETE FROM credentials WHERE account_id = ? AND users_id = ?;");
        $stmt->execute(array($id, $user_id));
        $_SESSION['success'] = 'Credential deleted successfully.';
    } else {
        $_SESSION['error'] = 'Credential could not be deleted. Please try again.';
    }
    header("location: ../single.php?id=$site_id");
    exit();
}

if (isset($_POST["add_credential"])) {
    $user_id = $_SESSION["userid"];
    $site_id = $_POST["site_id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    $encypted_pwd = $aes->encrypt($password, $_SESSION["password"]);

    try {
        $stmt = $dbh->prepare("INSERT INTO credentials(users_id, site_id, username, password, notes) VALUES (?,?,?,?,?);");
        $stmt->execute(array($user_id, $site_id, $username, $encypted_pwd, $notes));
        $_SESSION['success'] = 'Credential added successfully.';
        header("location: ../single.php?id=$site_id");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Credential could not be added. Please try again.';
        if (isset($_SESSION['site_id']) && $_SESSION['site_id'] != ''){
            header("location: ../single.php?id=" . $_SESSION['site_id']);
            exit();
        }
        header("location: ../dashboard.php");
        exit();
    }
}
