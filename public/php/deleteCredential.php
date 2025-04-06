<?php

session_start();
include_once 'dbh.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Grabbing the data
    $id = $_POST["id"];
    $user_id = $_SESSION["userid"];

    try {
        $dbh->beginTransaction();
        $stmt = $dbh->prepare("DELETE FROM credentials WHERE account_id = ?;");
        $stmt->execute(array($id));
        $dbh->commit();
    } catch (PDOException $e) {
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

// Going back to front page
header("location: ../single.php?site_id=");
