<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="heading">
                <h1>Login</h1>
            </div>
            <div class="form">
                <form action="includes/login-inc.php" method="POST">
                    <!-- Username Input -->
                    <input type="uname" class="input" name="uname" placeholder="Username"><br>
                    <!-- Password Input -->
                    <input type="password" class="input" name="pwd" placeholder="password"><br>
                    <!-- Register -->
                    <span>Dont have a account?&nbsp;<a id="show-popup-btn">Register</a></span><br>
                    <!-- Login Button -->
                    <button type="submit" name="login">Login</button>
                </form>
            </div>
        </div>
        <div class="popup" id="popup" style="display: none;">
            <span class="material-symbols-outlined close-btn" id="close-btn">
                close
            </span>
            <div class="heading">
                <h1>Signup</h1>
            </div>
                <form action="includes/signup-inc.php" class="signup_form" method="POST">
                    <!-- Name Input -->
                    <div>                    
                        <input type="text" class="input" name="uname" placeholder="UserName"><br>
                    </div>                    
                    <!-- Username Input -->
                    <div>                    
                        <input type="email" class="input" name="email" placeholder="Email"><br>
                    </div>                    
                    <!-- Password Input -->
                    <div>                    
                        <input type="password" class="input" name="pwd" placeholder="Password"><br>
                    </div>
                    <div>                    
                        <input type="password" class="input" name="pwdRepeat" placeholder="Repeat Password"><br>
                    </div>
                    <!-- Login Button -->
                    <button type="submit" name="submit">Register</button>
                </form>
        </div>
    </div>
    <script src="/assets/js/pop.js"></script>
</body>
</html>