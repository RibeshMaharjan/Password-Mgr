<?php

include "../app/config/dbh.php";
include "../app/helpers/session_helper.php";
include "../app/models/credential.php";
include "../app/controllers/credential.php";

if (isset($_POST["GET"])) 
{
    // Grabbing the data
    $uname = $_POST["users_id"];
    $pwd = $_POST["site"];
    $pwd = $_POST["username"];
    $pwd = $_POST["password"];

    // Instantiate SignupContr class
    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../index.php?error=none");
}

if (isset($_POST["add"])) 
{
    // Grabbing the data
    $user_id = $_SESSION["userid"];
    $site = $_POST["site"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Instantiate CredentialController
    $credential = new CredentialController($user_id, $site, $username, $password);

    // Running error handlers and user signup
    $credential->addCredentials();

    // Going back to front page
    header("location: ../index.php?error=none");
}

if (isset($_POST["update"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    include "../config/dbh.php";
    include "../models/login.php";
    include "../controllers/login.php";

    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../index.php?error=none");
}

if (isset($_POST["delete"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    include "../config/dbh.php";
    include "../models/login.php";
    include "../controllers/login.php";

    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../index.php?error=none");
}