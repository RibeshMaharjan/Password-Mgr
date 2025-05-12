<?php
    session_start();



    if(isset($_POST["logout"])){
//        unset($_SESSION['auth']);
        if(session_unset() && session_destroy()){
            $_SESSION['success'] = "Logged out successfully!";
            header("location: ./login.php");
            exit();
        }
        echo 'zzzzzzzzz';
    }