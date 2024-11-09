<?php

session_start();

if (isset($_POST["save"])) 
{
    // Grabbing the data
    $saltKey = $_SESSION["password"];
    $user_id = $_POST["userid"];
    $uname = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    // Instantiate SignupContr class
    require_once __DIR__.'/../app/dbh.php';
    include "../app/models/userprofilemodel.php";
    // include "../app/config/dbh.php"; 
    include "../app/controllers/userprofilecontroller.php";
    
    $userProfile = new Userprofilecontroller();
    $userProfile->updateProfile($user_id, $uname, $email, $pwd, $saltKey);
    // Going back to front page
    header("location: ../public/userprofile.php?error=none");
}