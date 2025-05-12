<?php

session_start();
include_once 'dbh.php';
include_once '../lib/aes.php';
$aes = new AES();


if (isset($_POST["add_site"])) {
    $site_name = $_POST["site_name"];
    $site_url = $_POST["site_url"];
    try {
        $stmt = $dbh->prepare("INSERT INTO sites(user_id, site_name, site_url) VALUES (?,?,?);");
        $stmt->execute(array($_SESSION['userid'],$site_name, $site_url));
        $_SESSION['site_id'] = $dbh->lastInsertId();
        $_SESSION['success'] = 'Site added successfully.';
        header("location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Site could not be added. Please try again.';
        if (isset($_SESSION['site_id']) && $_SESSION['site_id'] != ''){
            header("location: ../single.php?id=" . $_SESSION['site_id']);
            exit();
        }

    }
}

if (isset($_POST["update_site"])) {
    $site_name = $_POST["site_name"];
    $site_url = $_POST["site_url"];
    try {
        $stmt = $dbh->prepare("INSERT INTO sites(user_id, site_name, site_url) VALUES (?,?,?);");
        $stmt->execute(array($_SESSION['userid'],$site_name, $site_url));
        $_SESSION['site_id'] = $dbh->lastInsertId();
        $_SESSION['success'] = 'Site added successfully.';
        header("location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Site could not be added. Please try again.';
        if (isset($_SESSION['site_id']) && $_SESSION['site_id'] != ''){
            header("location: ../single.php?id=" . $_SESSION['site_id']);
            exit();
        }

    }
}


if (isset($_POST["delete_site"])) {
    $site_id = $_POST["site_id"];

    try {
        $stmt = $dbh->prepare("DELETE FROM sites WHERE site_id = ?;);");
        $stmt->execute(array($site_id));;
        $_SESSION['success'] = 'Site deleted successfully.';
        header("location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Site could not be deleted. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }
}
