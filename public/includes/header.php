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
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
            crossorigin="anonymous">
        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="my-container">
        <?php include './includes/sidebar.php'; ?>
        <div class="content">
            <header>
                <ul class="nav justify-content-end py-3 px-5">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Welcome <?= $_SESSION["username"]; ?></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li> -->
                    <li class="nav-item">
                        <form action="logout.php" method="POST">
                            <button type="submit" class="logout-btn" name="logout">Logout</button>
                        </form>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li> -->
                </ul>
                <hr>
            
            </header>