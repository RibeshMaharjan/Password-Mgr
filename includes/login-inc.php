<?php

if (isset($_POST["login"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    require_once __DIR__.'/../app/dbh.php';
    // include "../app/config/dbh.php"; 
    include "../app/models/login.php";
    include "../app/controllers/login.php";

    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../public/index.php?error=none");
}