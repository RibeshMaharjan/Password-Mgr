<?php

    session_start();

    if(isset($_POST["logout"])){
        session_unset();
        unset($_SESSION['auth']);
        session_destroy();
        header("location: login.php?error=none");
        exit();
    }