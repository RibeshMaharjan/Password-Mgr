<?php include './includes/header.php'; ?>
    <div class="container">
        <main>
            <div class="main-body">
                <div class="title">
                    <h1>Passwords</h1>
                    <div class="button-section">
                        <a class="pass-mgr-button site-add-button" data-bs-toggle="collapse" href="#site-add-form" role="button" aria-expanded="false" aria-controls="credential-add-form"><i class="fa-solid fa-plus"></i>Add New</a>
                    </div>
                </div>
                <div class="site-add-form collapse" id="site-add-form">
                    <form action="../app/controllers/credential.php" method="POST">
                        <h3 class="title add-form-title">Enter Site Details</h3>
                        <div class="form-site">
                            <div class="credential-left">
                                <div class="credential-info-group">
                                    <label for="site_name">Site</label>
                                    <input type="text" placeholder="site" name="site_name">
                                </div>
                            </div>
                            <div class="credential-right">
                                <div class="credential-info-group">
                                    <label for="site_url">Url</label>
                                    <input type="text" placeholder="Site Url" name="site_url">
                                </div>
                            </div>
                        </div>
                        <h3 class="title add-form-title">Enter your Credentials</h3>
                        <div class="form-credential">
                            <div class="credential-left">
                                <div class="credential-info-group">
                                    <label for="username">Username</label>
                                    <input type="text" placeholder="site" name="username">
                                </div>
                                <div class="credential-info-group">
                                    <label for="password">Password</label>
                                    <input type="text" placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="credential-right">
                                <div class="credential-info-group">
                                    <label for="notes">Notes</label>
                                    <input type="textarea" name="notes" placeholder="No Notes Added">
                                </div>
                            </div>
                        </div>
                        <div class="site-add-button-group">
                            <button type="submit" class="pass-mgr-button submit-btn" name="add">Submit</button>
                        </div>
                    </form>
                </div>
                <?php
                    $siteController = new SiteController();
                    $siteController->showSites();
                ?>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>