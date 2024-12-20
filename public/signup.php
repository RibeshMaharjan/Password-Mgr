<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- <link rel="stylesheet" href="assets/css/styles.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Sign Up</h1>
            </div>
            <div class="form">
                <form action="../includes/signup-inc.php" method="POST">
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
                    <!-- Repeat Password Input -->
                    <div>                    
                        <input type="password" class="input" name="pwdRepeat" placeholder="Repeat Password"><br>
                    </div>
                    <!-- Login -->
                    <span>Already have a account?&nbsp;<a href="login.php">Login</a></span><br>
                    <!-- SignUp Button -->
                    <button type="submit" name="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>