<?php
    $user_id = $_SESSION["userid"];

    if(isset($data['message'])){
        echo $data['message'];
    }
?>

<form action="../includes/update-profile-inc.php?" method="POST">
    <input type="hidden" name="userid" value="<?= $data['user']['user_id'] ?>">
    <div class="profile-form-input-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= $data['user']['users_name'] ?>">
    </div>
    <div class="profile-form-input-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= $data['user']['users_email'] ?>">
    </div>
    <div class="profile-form-input-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="<?= $data['user']['decrypted_password'] ?>">
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
                exit();
            }
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
            passwordField.type = 'password';
        });
    </script>
    <button class="pass-mgr-button" type="submit" name="save">Save</button>
</form>