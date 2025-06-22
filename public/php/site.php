<?php

session_start();
include_once 'dbh.php';
include_once '../lib/aes.php';
$aes = new AES();

if (isset($_POST["add_site"])) {
    $site_name = $_POST["site_name"];
    $site_url = $_POST["site_url"];

    if(empty($site_name) || empty($site_url)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("location: ../dashboard.php");
        exit();
    }

    if (
        !filter_var($site_url, FILTER_VALIDATE_URL) ||
        strpos(parse_url($site_url, PHP_URL_HOST), 'www.') !== 0
    ) {
        $_SESSION['error'] = 'Site URL is invalid. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }

    $stmt = $dbh->prepare("SELECT * FROM sites WHERE site_url = ? AND user_id = ?;");
    $stmt->execute(array($site_url, $_SESSION['userid']));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($data['site_url'] == $site_url) {
        $_SESSION['error'] = 'Site already exists.';
        header("location: ../dashboard.php");
        exit();
    }

    try {
        $stmt = $dbh->prepare("INSERT INTO sites(user_id, site_name, site_url) VALUES (?,?,?);");
        $stmt->execute(array($_SESSION['userid'],$site_name, $site_url));
        $_SESSION['success'] = 'Site added successfully.';
        header("location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Site could not be added. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }
}

if (isset($_POST["update_site"])) {
    $site_id = $_POST["site_id"];
    $site_name = $_POST["site_name"];
    $site_url = $_POST["site_url"];

    if(empty($site_name) || empty($site_url)) {
        $_SESSION['error'] = 'Site could not be updated. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }

    if (
        !filter_var($site_url, FILTER_VALIDATE_URL) ||
        strpos(parse_url($site_url, PHP_URL_HOST), 'www.') !== 0
    ) {
        $_SESSION['error'] = 'Site URL is invalid. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }

    $stmt = $dbh->prepare("SELECT * FROM `sites` WHERE site_id != ? AND user_id = ?;");
    $stmt->execute(array($site_id, $_SESSION['userid']));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($data['site_url'] == $site_url) {
        $_SESSION['error'] = 'Site already exists.';
        header("location: ../dashboard.php");
        exit();
    }

    try {
        $stmt = $dbh->prepare("UPDATE sites SET 
                                                    site_name = ?,
                                                    site_url = ?
                                                    WHERE site_id = ?;");
        $stmt->execute(array($site_name, $site_url, $site_id));
        $_SESSION['success'] = 'Site added successfully.';
        header("location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = 'Site could not be added. Please try again.';
        header("location: ../dashboard.php?");
        exit();
    }
}


if (isset($_POST["delete_site"])) {
    $site_id = $_POST["site_id"];

    if(empty($site_id)) {
        $_SESSION['error'] = 'Site could not be deleted. Please try again.';
        header("location: ../dashboard.php");
        exit();
    }

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
