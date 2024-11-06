<?php include './includes/header.php'; ?>
    <div class="container">
        <main>
            <div class="main-body">
                <div class="title">
                    <h1>Passwords</h1>
                    <div class="button-section">
                        <a class="pass-mgr-button dashboard-add-button" data-bs-toggle="collapse" href="#credential-add-form" role="button" aria-expanded="false" aria-controls="credential-add-form"><i class="fa-solid fa-plus"></i>Add New</a>
                    </div>
                </div>
                <?php
                    $siteController = new SiteController();
                    $siteController->showSites();
                ?>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>