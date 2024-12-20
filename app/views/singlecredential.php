<?php
    if(isset($data['message'])){
        echo $data['message'];
    }
?>
<div class="credential-listing">
    <?php 
    // print_r($data);
    foreach($data as $row){
        ?>
            <form action="" method="post">
                <div class="credentials">
                    <div class="credential-left">
                        <input type="hidden" name="account_id" id="account_id" value="<?= $row['account_id'] ?>">
                        <div class="credential-info-group">
                            <label for="username">Username</label>
                            <div class="input-container">
                                <input type="text" value="<?= $row['username'] ?>">
                                <div class="copy-icon copy-btn" onclick="copyToClipboard(event)">
                                    <i class="fa-solid fa-copy"></i>
                                </div>
                                <!-- <button class="copy-btn" onclick="copyToClipboard()">&#x2398;</button> -->
                            </div>
                        </div>
                        <div class="credential-info-group">
                            <label for="password">Password</label>
                            <div class="input-container">
                                <input type="password" value="<?= $row['password'] ?>">
                                <div class="hidden-icon">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </div>
                                <div class="copy-icon copy-btn" onclick="copyToClipboard(event)">
                                    <i class="fa-solid fa-copy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="credential-right">
                        <div class="credential-info-group">
                            <label for="site">Site</label>
                            <div class="input"><?= $row['site_url'] ?></div>
                        </div>
                        <div class="credential-info-group">
                            <label for="notes">Notes</label>
                            <input type="textarea" value="<?= $row['notes'] ?>" placeholder="No Notes Added">
                        </div>
                    </div>
                    <div class="credential-button-group">
                        <button type="button" class="pass-mgr-button edit-btn" id="edit-btn">
                            Edit
                        </button>
                        <button type="button" class="pass-mgr-button delete-btn" id="delete-btn" data-bs-toggle="modal" data-bs-target="#credential-delete">
                            Delete
                        </button>
                    </div>
                </div>
            </form>
        <?php
        }
        ?>
</div>
<script>
    const hiddenIcon = document.querySelectorAll(".hidden-icon");

    hiddenIcon.forEach(hiddenIcon => {
        hiddenIcon.addEventListener('click', function(e){
        const icon = document.querySelector(".hidden-icon .fa-solid");
        const inputContainer = e.target.closest(".input-container");
        const passwordField = inputContainer.querySelector("input");
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
    });
    

    function copyToClipboard(event) {
        const inputContainer = event.target.closest(".input-container");
        const inputField = inputContainer.querySelector("input");
        copyText = inputField.value;
        navigator.clipboard.writeText(copyText);  
    }
</script>