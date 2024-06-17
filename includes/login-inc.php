<?php

if (isset($_POST["login"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    include "../classes/dbhclasses.php";
    include "../classes/loginclasses.php";
    include "../classes/login-controller.php";

    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../login.php?error=none");
}