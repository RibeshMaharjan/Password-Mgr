<?php

require_once '../app/init.php';
require_once __DIR__.'/../app/dbh.php';
require_once '../app/helpers/session_helper.php';
include __DIR__."/../app/models/credentialmodel.php";
include __DIR__."/../app/controllers/credential.php";

$app = new App;

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
            <h1>Welcome <?= $_SESSION["username"]; ?></h1>
            <form action="logout.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form><br><br>
            
        </header>
        <main>
            <h3>Enter your Credentials</h3>
            <form action="../includes/credential-inc.php" class="signup_form" method="POST">
                <!-- Site Input -->
                <div>                    
                    <input type="text" class="input" name="site" placeholder="Site"><br>
                </div>  
                <!-- Name Input -->
                <div>                    
                    <input type="text" class="input" name="username" placeholder="UserName"><br>
                </div>                    
                <!-- Password Input -->
                <div>                    
                    <input type="password" class="input" name="password" placeholder="Password"><br>
                </div>
                <!-- Add Button -->
                <button type="submit" name="add">Register</button>
            </form><br><br>
            <div class="container ms-0">
                <h3>Your Credentials</h3>
                <?php 
                    $credential = new Credential();
                    $data = $credential->showCredentials(); 
                ?>
            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
