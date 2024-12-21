<?php

session_start();

if (isset($_POST["generate"])) 
{
    // Grabbing the data
    $length = $_POST["length"];
    $lowercase = $_POST["lowercase"];
    $uppercase = $_POST["uppercase"];
    $number = $_POST["number"];
    $symbols = $_POST["symbol"];

    // Instantiate SignupContr class
    require_once __DIR__.'/../app/dbh.php';
    include "../app/models/passwordgeneratormodel.php";
    include "../app/controllers/passwordgeneratorcontroller.php";
    
    $generator = new GeneratorController();
    $generator->generatePassword($length, $lowercase, $uppercase, $number, $symbols);

    // Going back to front page
    header("location: ../public/passwordgenerator.php");
}