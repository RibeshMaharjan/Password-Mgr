<?php include_once './php/dbh.php'; ?>
<?php include './includes/header.php'; ?>
<?php include './includes/nav.php'; ?>
    <div class="container">
        <main>
            <?php
                if(isset($_POST['site_id'])){
                    $_SESSION['site_id'] = $_POST['site_id'];
                }
                $site_id = $_SESSION['site_id'];

                $stmt = $dbh->prepare("SELECT * FROM sites WHERE site_id = :site_id;");
                $stmt->bindParam(':site_id', $site_id);
                $stmt->execute();

                $site = $stmt->fetch(PDO::FETCH_ASSOC);

            ?>

            <!-- Modal -->
            <div class="modal fade" id="credential-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./php/updateCredential.php" id="form-credential-edit" method="POST">
                        <input type="hidden" name="id" id="id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                            <label for="floatingPassword">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="textarea" class="form-control" id="notes" placeholder="Notes" name="notes">
                            <label for="floatingInput">Notes</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">Submit</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade" id="credential-delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./php/deleteCredential.php" method="POST" id="form-delete">
                        <label>Are you Sure?</label>
                        <input type="hidden" name="id" id="delete-id">
                        <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <?php
               if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
                   $user_id = $_SESSION["userid"];
                   $username = $_POST["username"];
                   $password = $_POST["password"];
                   $notes = $_POST["notes"];
                   $site_id = $site['site_id'];

                   if (!empty($username) && !empty($password) && !empty($site_id)) {
                        $salt = $_SESSION["password"];

                       $stmt = $dbh->prepare("INSERT INTO credentials (users_id, site_id, username, password, notes) VALUES (?,?,?,AES_ENCRYPT(?,?),?);");
                       $stmt->execute(array($user_id, $site_id, $username, $password, $salt, $notes));
                       $_SESSION['site_id'] = $site_id;
                   } else {
                       echo '<div class="alert alert-danger" role="alert"  style="background-color: #2b5fb31f;">Please fill all fields.</div>';
                   }
               }
           ?>
            <div class="credential-single-body">
                <div class="title">
                    <div class="back-icon">
                        <i class="fa-solid fa-arrow-left" onclick="window.location.href = 'index.php';"></i>
                    </div>
                    <h1>Your <?= $site['site_name'] ?> Credentials</h1>
                    <div class="button-section">
                        <a class="pass-mgr-button dashboard-add-button" data-bs-toggle="collapse" href="#credential-add-form" role="button" aria-expanded="false" aria-controls="credential-add-form"><i class="fa-solid fa-plus"></i>Add New</a>
                    </div>
                </div>
                <div class="credential-add-form collapse" id="credential-add-form">
                    <h3 class="add-form-title">Enter your Credentials</h3>
                    <form method="POST">
                        <div class="credential-left">
                            <div class="credential-info-group">
                                <label for="username">Username</label>
                                <input type="text" placeholder="site" name="username" value="<?= $_POST['username'] ?? '' ?>">
                            </div>
                            <div class="credential-info-group">
                                <label for="password">Password</label>
                                <input type="text" placeholder="Password" name="password" value="<?= $_POST['password'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="credential-right">
                            <div class="credential-info-group">
                                <label for="site">Site</label>
                                <input type="hidden" name="site_id" value="<?= $site['site_id'] ?>">
                                <div class="input"><?= $site['site_url'] ?></div>
                            </div>
                            <div class="credential-info-group">
                                <label for="notes">Notes</label>
                                <input type="textarea" name="notes" placeholder="No Notes Added" value="<?= $_POST['notes'] ?? '' ?>">>
                            </div>
                        </div>
                        <div class="credential-button-group">
                            <button type="submit" class="pass-mgr-button submit-btn" name="add">Submit</button>
                        </div>
                    </form>
                </div>
                <?php

                    $stmt = $dbh->prepare("SELECT credentials.account_id, credentials.username, AES_DECRYPT(credentials.password,?) as password, credentials.notes, sites.site_name, sites.site_url FROM credentials INNER JOIN sites ON credentials.site_id = sites.site_id WHERE credentials.users_id = ? AND sites.site_id=?;");
                    $stmt->execute(array($_SESSION["password"], $_SESSION["userid"], $site_id));
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                ?>
                <div class="credential-listing">
                <?php
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
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>