<?php

require_once './helpers/session_helper.php';
require_once './lib/functions.php';
require_once './php/dbh.php';

if(!isset($_SESSION['auth']))
{
    header('Location: ./login.php');
}

if(checkVerification()) {
    header('Location: ./index.php');
}
?>
<?php
    include './includes/header.php';
?>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Verify your Email</h1>
            </div>
            <div class="form">
                <form method="POST" action="./php/verifyUser.php">
                    <?php
                    if(isset($_SESSION['error'])) {
                        echo '<div class="alert alert-dark text-dark" role="alert">'.$_SESSION['error'].'</div>';
                        unset($_SESSION['error']);
                    }
                    if(isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success text-dark" role="alert">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>
                    <!-- Verification Code Input -->
                    <input type="text" class="input" name="verification_code" placeholder="Verification Code" /><br>
                    <!-- Login Button -->
                    <button type="submit" name="verify">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>