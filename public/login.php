<?php

require_once './helpers/session_helper.php';
require_once './php/dbh.php';

if(isset($_SESSION['auth']))
{
    header('Location: ./index.php');
}
?>
<?php
    include './includes/header.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uname = $_POST['uname'];
        $pwd = $_POST['pwd'];

        if (!empty($uname) && !empty($pwd)) {
            $stmt = $dbh->prepare('SELECT users_salt FROM users WHERE users_name = ? OR users_email = ?;');
            $stmt->execute(array($uname, $uname));

            if ($stmt->rowCount() > 0) {
                $salt = $stmt->fetch(PDO::FETCH_ASSOC)["users_salt"];

                $stmt = $dbh->prepare('SELECT AES_DECRYPT(users_pwd, ?) AS decrypted_password FROM users WHERE users_name = ? OR users_email = ?');
                $stmt->execute(array($salt, $uname, $uname));

                $decryptPwd = $stmt->fetch(PDO::FETCH_ASSOC);
                $checkPwd = ($pwd == $decryptPwd['decrypted_password']) ? true : false;

                if($checkPwd) {
                    $stmt = $dbh->prepare('SELECT * FROM users WHERE (users_name = ? OR users_email = ?) AND users_pwd = AES_ENCRYPT(?,?);');
                    $stmt->execute(array($uname, $uname, $pwd, $salt));
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['auth'] = true;
                    $_SESSION["userid"] = $user["user_id"];
                    $_SESSION["username"] = $user["users_name"];
                    $_SESSION["password"] = $user["users_salt"];
                } else {
                    echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">Wrong password.<br>Please try again.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">User does not exits.<br>Please try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">Please fill all fields.</div>';
        }
    }
?>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Login</h1>
            </div>
            <div class="form">
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