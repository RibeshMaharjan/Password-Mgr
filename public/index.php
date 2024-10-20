<?php include './includes/header.php'; ?>
    <div class="container">
        <main class="d-none">
            <div class="container-fluid mt-4 mx-2">
                <h3 class="mb-2">Enter your Credentials</h3>
                <form action="../app/controllers/credential.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="site" name="site">
                        <label for="floatingInput">Site</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="add">Submit</button>
                </form>
            </div>

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
                    <form action="../app/controllers/credential.php" method="POST">
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

            <div class="my-table mt-5 mx-4">
                <h3>Your Credentials</h3>
                <?php 
                    $credential = new Credential();
                    $data = $credential->showCredentials(); 
                ?>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>