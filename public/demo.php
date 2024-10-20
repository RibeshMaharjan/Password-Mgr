<?php
    session_start();
    echo $_SESSION['auth'];
    echo "<br>";
    echo $_SESSION["userid"];
    echo "<br>";
    echo $_SESSION["username"];