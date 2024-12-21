<?php

require_once '../app/helpers/session_helper.php';
require_once __DIR__.'/../../app/dbh.php';
require_once __DIR__.'/../../app/config/function.php';
include __DIR__."/../../app/controllers/credential.php";
include __DIR__."/../../app/controllers/userprofilecontroller.php";
include __DIR__."/../../app/controllers/sitecontroller.php";
include __DIR__."/../../app/controllers/passwordgeneratorcontroller.php";

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
        <link rel="stylesheet" href="./assets/css/styles.css">

    </head>
    <body>
            <header class="primary-header">
                <div>
                    <img src="./assets/images/logo/logo2preview.png" alt="" class="logo">
                </div>

                <button class="mobile-nav-toggle" aria-expanded="false">
                </button>

                <nav>
                    <ul id="primary-navigation" class="primary-navigation" data-visible="false">
                        <li class="active">
                            <a href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="./passwordgenerator.php">
                                Password Generator
                            </a>
                        </li>
                        <li>
                            <a href="./userprofile.php">
                                Profile
                            </a>
                        </li>
                        <li>
                        <form action="logout.php" method="POST" id="logout-form">
                            <input type="hidden" name="logout">
                            <a href="" onclick="submitLogoutForm(event)">
                                Logout
                            </a>
                        </form>
                        </li>
                        <script>
                            function submitLogoutForm(event) {
                                event.preventDefault();
                                document.getElementById("logout-form").submit();
                            }
                        </script>
                    </ul>
                </nav>
            </header>
            <div class="content">
