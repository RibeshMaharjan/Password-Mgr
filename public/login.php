<?php

require_once './helpers/session_helper.php';
require_once './php/dbh.php';
require_once './lib/aes.php';

$aes = new AES();

if(isset($_SESSION['auth']))
{
    header('Location: ./index.php');
}
?>
<?php
    include './includes/header.php';
?>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Login</h1>
            </div>
            <div class="form">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $uname = $_POST['uname'];
                        $pwd = $_POST['pwd'];

                        if (!empty($uname) && !empty($pwd)) {
                            $stmt = $dbh->prepare('SELECT users_salt FROM users WHERE users_name = ? OR users_email = ?;');
                            $stmt->execute(array($uname, $uname));

                            if ($stmt->rowCount() > 0) {
                                $salt = $stmt->fetch(PDO::FETCH_ASSOC)["users_salt"];

                                $stmt = $dbh->prepare('SELECT users_pwd FROM users WHERE users_name = ? OR users_email = ?');
                                $stmt->execute(array($uname, $uname));

                                $decryptPwd = $stmt->fetch(PDO::FETCH_ASSOC);

                                $password = $aes->encrypt($pwd, $salt);
                                $checkPwd = ($password == $decryptPwd['users_pwd']) ? true : false;

                                if($checkPwd) {
                                    $stmt = $dbh->prepare('SELECT * FROM users WHERE (users_name = ? OR users_email = ?) AND users_pwd = ?;');
                                    $stmt->execute(array($uname, $uname, $password));
                                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $_SESSION['auth'] = true;
                                    $_SESSION["userid"] = $user["user_id"];
                                    $_SESSION["username"] = $user["users_name"];
                                    $_SESSION["email"] = $user["users_email"];
                                    $_SESSION["password"] = $user["users_salt"];
                                } else {
                                    echo '<div class="alert alert-dark text-dark" role="alert">Wrong password.<br>Please try again.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-dark text-dark" role="alert">User does not exits.<br>Please try again.</div>';
                            }
                        } else {
                            echo '<div class="alert alert-dark text-dark" role="alert">Please fill all fields.</div>';
                        }
                    }    
                ?>
                <form method="POST">
                    <!-- Username Input -->
                    <input type="text" class="input" name="uname" placeholder="Username" value="<?= $_POST['uname'] ?? '' ?>"><br>
                    <!-- Password Input -->
                    <input type="password" class="input" name="pwd" placeholder="password" value="<?= $_POST['pwd'] ?? '' ?>"><br>
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