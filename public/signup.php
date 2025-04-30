<?php

require_once './helpers/session_helper.php';
require_once __DIR__.'/php/dbh.php';
require_once './lib/aes.php';

$aes = new AES();

if(isset($_SESSION['auth']))
{
    header('Location: ../public/index.php');
}
?>
<?php
    include './includes/header.php';
?>
    <div class="login-signup-bg">
        <div class="login-signup-wrapper">
            <div class="heading">
                <h1>Sign Up</h1>
            </div>
            <div class="form">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $uname = $_POST['uname'];
                        $email = $_POST['email'];
                        $pwd = $_POST['pwd'];
                        $pwdRepeat = $_POST['pwdRepeat'];

                        if (!empty($uname) && !empty($email) && !empty($pwd) && !empty($pwdRepeat)) {
                            $stmt = $dbh->prepare('SELECT users_email FROM users WHERE users_name = ? OR users_email = ?;');
                            $stmt->execute(array($uname, $email));

                            if ($stmt->rowCount() == 0) {
                                $stmt = $dbh->prepare('INSERT INTO users (users_name, users_email, users_pwd, users_salt) VALUES (?,?,?,?);');
                                $salt = openssl_random_pseudo_bytes(24);
                                $iterations = 10000;
                                $keyLength = 24;
                                $key = hash_pbkdf2("sha256", $pwd, $salt, $iterations, $keyLength, true);

                                $encypted_pwd = $aes->encrypt($pwd, $key);

                                $stmt->execute(array($uname, $email, $encypted_pwd, $key));

                                echo "<meta http-equiv='refresh' content='0;url=login.php'>";
                                exit();
                            } else {
                                echo '<div class="alert alert-dark text-dark" role="alert">User already exist</div>';
                            }
                        } else {
                            echo '<div class="alert alert-dark text-dark" role="alert">Please fill all fields.</div>';
                        }
                    }
                ?>
                <form method="POST">
                    <!-- Name Input -->
                    <div>
                        <input type="text" class="input" name="uname" placeholder="UserName" value="<?= $_POST['uname'] ?? '' ?>"><br>
                        <div class="d-flex justify-content-center" id="div1"></div>
                    </div>
                    <!-- Username Input -->
                    <div>
                        <input type="email" class="input" name="email" placeholder="Email" value="<?= $_POST['email'] ?? '' ?>"><br>
                        <div class="d-flex justify-content-center" id="div2"></div>
                    </div>
                    <!-- Password Input -->
                    <div>
                        <input type="password" class="input" name="pwd" placeholder="Password" value="<?= $_POST['pwd'] ?? '' ?>"><br>
                        <div class="d-flex justify-content-center" id="div3"></div>
                    </div>
                    <!-- Repeat Password Input -->
                    <div>                    
                        <input type="password" class="input" name="pwdRepeat" placeholder="Repeat Password" value="<?= $_POST['pwdRepeat'] ?? '' ?>"><br>
                        <div class="d-flex justify-content-center" id="div4"></div>
                    </div>
                    <div class="d-flex justify-content-center" id="div5"></div>
                    <!-- Login -->
                    <span>Already have a account?&nbsp;<a href="login.php">Login</a></span><br>
                    <!-- SignUp Button -->
                    <button type="submit" id="send" name="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/validation.js"></script>
</body>
</html>