<?php

include "../app/config/dbh.php";
include "../app/helpers/session_helper.php";
include "../app/models/credential.php";
include "../app/controllers/credential.php";

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
    header("location: ../public/index.php?error=none");header("location: ../public/index.php?error=none");
}