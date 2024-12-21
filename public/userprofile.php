<?php include './includes/header.php'; ?>
<?php

$user_id = $_SESSION["userid"];

?>
    <div class="container">
        <main>
            <div class="profilebody">
                <div class="title">
                    <h1>User Info</h1>
                </div>
                <div class="body">
                    <?php 
                        $userProfle = new Userprofilecontroller();
                        $userProfle->profile($user_id); 
                    ?>
                </div>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>