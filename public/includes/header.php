<?php

// require_once '../app/init.php';
require_once '../app/helpers/session_helper.php';
require_once __DIR__.'/../../app/dbh.php';
include __DIR__."/../../app/controllers/credential.php";
include __DIR__."/../../app/controllers/userprofilecontroller.php";
include __DIR__."/../../app/controllers/sitecontroller.php";

// $app = new App;
// session_start();

if(!isset($_SESSION['auth']))
{
    header('Location: ../public/login.php');
}

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
        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <!-- Tomorrow Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
            rel="stylesheet">
        <!-- Montserrat Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" 
            rel="stylesheet">

        <!-- Poppins Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
            rel="stylesheet">

        <!-- Font Awesome Cdn -->
        <script 
            src="https://kit.fontawesome.com/922cd10ce2.js" 
            crossorigin="anonymous">
        </script>

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
            crossorigin="anonymous">

        <!-- Main Css -->
        <link rel="stylesheet" href="./assets/css/style.css">

    </head>
    <body>
            <?php
                // include './includes/sidebar.php';
            ?>
            <header class="primary-header">
                <div>
                    <img src="./assets/images/logo/logo2preview.png" alt="" class="logo">
                </div>

                <button class="mobile-nav-toggle" aria-expanded="false">
                    <!-- <i class="fa-solid fa-bars"></i> -->
                </button>

                <nav>
                    <ul id="primary-navigation" class="primary-navigation" data-visible="false">
                        <li class="active">
                            <a href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Password Generator
                            </a>
                        </li>
                        <li>
                            <a href="./userprofile.php">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
            <div class="content">
                <!-- <header>
                    <nav class="home-navbar">
                        <ul class="nav-bar">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Welcome </a>
                            </li>
                            <li class="nav-item">
                                <form action="logout.php" method="POST">
                                    <button type="submit" class="logout-btn" name="logout">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                    <hr>
                </header> -->
