<?php

if (isset($_POST["submit"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];

    // Instantiate SignupContr class
    include "../config/dbh.php";
    include "../models/signup.php";
    include "../controllers/signup.php";

    $signup = new SignupController($uname, $email, $pwd, $pwdRepeat);

    // Running error handlers and user signup
    $signup->signupUser();

    // Going back to front page
    header("location: ../login.php?error=none");
}