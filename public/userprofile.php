<?php include_once './php/dbh.php'; ?>
<?php include_once './lib/functions.php'; ?>
<?php include_once './includes/header.php'; ?>
<?php include_once './includes/nav.php'; ?>

<?php
    require_once './lib/aes.php';

    $aes = new AES();
?>

<?php
    $user_id = $_SESSION["userid"];
    $saltKey = $_SESSION["password"];
    $userInfo = getUserInfo();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Grabbing the data
        $saltKey = $_SESSION["password"];
        $user_id = $_POST["userid"];
        $uname = $_POST["username"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];

        $encypted_pwd = $aes->encrypt($pwd, $saltKey);

        $stmt = $dbh->prepare("UPDATE users SET 
                                        users_name = :username,
                                        users_email = :email,
                                        users_pwd = :pwd
                                        WHERE user_id = :user_id");
        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $encypted_pwd);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        // Update the user variable
        $userInfo = getUserInfo();
    }
?>
    <div class="container">
        <main>
            <div class="profilebody">
                <div class="title">
                    <h1>User Info</h1>
                </div>
                <div class="body">
                    <form method="POST">
                        <input type="hidden" name="userid" value="<?= $userInfo['user_id'] ?>">
                        <div class="profile-form-input-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" value="<?= $userInfo['users_name'] ?>">
                        </div>
                        <div class="profile-form-input-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $userInfo['users_email'] ?>">
                        </div>
                        <div class="profile-form-input-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" value="<?= $userInfo['pwd'] ?>">
                            <div class="hidden-icon">
                                <i class="fa-solid fa-eye-slash"></i>
                            </div>
                        </div>
                        <script>
                            const hiddenIcon = document.querySelector(".hidden-icon");
                            hiddenIcon.addEventListener('click', function(){
                                const icon = document.querySelector(".hidden-icon .fa-solid");
                                const passwordField = document.getElementById('password');
                                if(icon.classList.contains("fa-eye-slash")){
                                    icon.classList.remove("fa-eye-slash");
                                    icon.classList.add("fa-eye");
                                    passwordField.type = 'text';
                                    return;
                                }
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                                passwordField.type = 'password';
                            });
                        </script>
                        <button class="pass-mgr-button" type="submit" name="save">Save</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>