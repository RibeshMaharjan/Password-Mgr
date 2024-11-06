<?php include './includes/header.php'; ?>
    <div class="container">
        <main>
            <?php
                if(isset($_POST['site_id'])){
                    $site_id = $_POST['site_id'];
                    $site_name = $_POST['site_name'];
                }
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
                    <form action="../app/controllers/credential.php" method="POST">
                        <input type="hidden" name="id" id="id">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="site" placeholder="Site" name="site">
                            <label for="floatingInput">Site</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                            <label for="floatingPassword">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">Submit</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update">Submit</button>
                </div> -->
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
                    <form action="../app/controllers/credential.php" method="POST" id="form-delete">
                        <label>Are you Sure?</label>
                        <input type="hidden" name="id" id="delete-id">
                        <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                    </form>
                </div>
                    <!-- <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div> -->
                </div>
            </div>
            </div>

            <div class="credential-single-body">
                <div class="title">
                    <div class="back-icon">
                        <i class="fa-solid fa-arrow-left" onclick="window.history.back();"></i>
                    </div>
                    <h1>Your <?= $site_name ?> Credentials</h1>
                    <div class="button-section">
                        <a class="pass-mgr-button dashboard-add-button" data-bs-toggle="collapse" href="#credential-add-form" role="button" aria-expanded="false" aria-controls="credential-add-form"><i class="fa-solid fa-plus"></i>Add New</a>
                    </div>
                </div>
                <div class="credential-add-form collapse" id="credential-add-form">
                    <h3 class="add-form-title">Enter your Credentials</h3>
                    <form action="../app/controllers/credential.php" method="POST">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="site" name="site">
                            <label for="floatingInput">Site</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating form-floating--full-width">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="pass-mgr-button" name="add">Submit</button>
                    </form>
                </div>
                <?php 
                    $credential = new Credential();
                    $data = $credential->showCredentials($site_id); 
                ?>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>