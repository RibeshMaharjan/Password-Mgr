<?php
//
//// Set a custom exception handler
//set_exception_handler(function ($exception) {
//    // Log the exception or handle it here
//    $_SESSION['error'] = 'An unexpected error occurred. Please try again later.';
//    header('Location: ./../signup.php');
//    exit();
//});
//
//// Set a custom error handler to catch fatal errors
//register_shutdown_function(function () {
//    $error = error_get_last();
//    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR])) {
//        // Fatal error occurred
//        $_SESSION['error'] = 'A critical error occurred. Please try again later.';
//        header('Location: ./../signup.php');
//        exit();
//    }
//});

require_once __DIR__.'/../helpers/session_helper.php';
include_once __DIR__.'/../lib/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Password Manager</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Cdn -->
    <script src="https://kit.fontawesome.com/922cd10ce2.js" crossorigin="anonymous"></script>
</head>

