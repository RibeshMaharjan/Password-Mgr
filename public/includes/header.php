<?php

// require_once '../app/init.php';
require_once __DIR__.'/../../app/dbh.php';
require_once '../app/helpers/session_helper.php';
include __DIR__."/../../app/controllers/credential.php";

// $app = new App;

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link 
            rel="stylesheet" 
            href="assets/css/sidebar.css"
        />
        <link 
            rel="stylesheet" 
            href="assets/css/main.css"
        />
        <script 
            src="https://kit.fontawesome.com/922cd10ce2.js" 
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <div class="content">
            <header>
                <!-- place navbar here -->
                <h1>Welcome <?= $_SESSION["username"]; ?></h1>
                <form action="logout.php" method="POST">
                    <button type="submit" name="logout">Logout</button>
                </form><br><br>
                
            </header>