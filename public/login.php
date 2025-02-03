<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/login.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Login</h1>
            </div>
            <div class="form">
                <form action="../includes/login-inc.php" method="POST">
                    <!-- Username Input -->
                    <input type="text" class="input" name="uname" placeholder="Username"><br>
                    <!-- Password Input -->
                    <input type="password" class="input" name="pwd" placeholder="password"><br>
                    <!-- Register -->
                    <span>Dont have a account?&nbsp;<a href="signup.php">Register</a></span><br>

                    <!-- Login Button -->
                    <button type="submit" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>