<?php include_once './php/dbh.php'; ?>
<?php include_once './lib/aes.php'; ?>
<?php include_once './includes/header.php'; ?>
<?php include_once './includes/nav.php'; ?>
<?php
$aes = new AES();
?>
    <div class="container">
        <main>
            <div class="main-body">
                <div class="title">
                    <h1>Passwords</h1>
                    <div class="button-section">
                        <a class="pass-mgr-button site-add-button" data-bs-toggle="collapse" href="#site-add-form" role="button" aria-expanded="false" aria-controls="credential-add-form"><i class="fa-solid fa-plus"></i>Add New</a>
                    </div>
                </div>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $user_id = $_SESSION["userid"];
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $notes = $_POST["notes"];
                        $site_name = $_POST["site_name"];
                        $site_url = $_POST["site_url"];
                        $site_id = $site['site_id'] ?? '';

                        if (!empty($username) && !empty($password) && !empty($site_name) && !empty($site_url)) {
                            if($site_id == '') {
                                $stmt = $dbh->prepare("SELECT * FROM sites WHERE site_url = ?");
                                $stmt->execute(array($site_url));

                                if($stmt->rowCount() > 0) {
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $site_id = $result['site_id'];
                                } else {
                                    $stmt = $dbh->prepare("INSERT INTO sites(site_name, site_url) VALUES (?,?);");
                                    $stmt->execute(array($site_name, $site_url));
                                    $site_id = $dbh->lastInsertId();
                                }
                            }

                            $salt = $_SESSION["password"];

                            $encrypted_password = $aes->encrypt($password, $salt);

                            $stmt = $dbh->prepare("INSERT INTO credentials (users_id, site_id, username, password, notes) VALUES (?,?,?,?,?);");
                            $stmt->execute(array($user_id, $site_id, $username, $encrypted_password, $notes));
                            $_SESSION['site_id'] = $site_id;
                        } else {
                            echo '<div class="alert alert-dark text-dark" role="alert">Please fill all fields.</div>';
                        }
                    }
                ?>
                <?php
                if(isset($_SESSION['error'])) {
                    echo '<div class="alert alert-dark text-dark" role="alert">'.$_SESSION['error'].'</div>';
                    unset($_SESSION['error']);
                }
                if(isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success text-dark" role="alert">'.$_SESSION['message'].'</div>';
                    unset($_SESSION['message']);
                }
                ?>
                <div class="site-add-form collapse" id="site-add-form">
                    <form method="POST">
                        <h3 class="title add-form-title">Enter Site Details</h3>
                        <div class="form-site">
                            <div class="credential-left">
                                <div class="credential-info-group">
                                    <label for="site_name">Site</label>
                                    <input type="text" placeholder="site" name="site_name" value="<?= $_POST['site_name'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="credential-right">
                                <div class="credential-info-group">
                                    <label for="site_url">Url</label>
                                    <input type="text" placeholder="Site Url" name="site_url" value="<?= $_POST['site_url'] ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <h3 class="title add-form-title">Enter your Credentials</h3>
                        <div class="form-credential">
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
                                    <label for="notes">Notes</label>
                                    <input type="textarea" name="notes" placeholder="No Notes Added" value="<?= $_POST['notes'] ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="site-add-button-group">
                            <button type="submit" class="pass-mgr-button submit-btn" name="add">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="site-listing">
                    <?php

                    $stmt = $dbh->prepare("SELECT * FROM sites");
                            $stmt->execute();

                            $siteResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // $stmt = null;
                            $stmt = $dbh->prepare("SELECT * FROM credentials WHERE users_id = :user_id");
                            $stmt->bindParam(':user_id', $_SESSION['userid']);
                            $stmt->execute();
                            $credentials = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $sites = [];

                            foreach($siteResult as $site){
                                    $count = 0;
                                foreach($credentials as $credential){
                                    if($site['site_id'] == $credential['site_id']) {
                                        $count++;
                                    }
                                }
                                if($count > 0){
                                    $site['count'] = $count;
                                    $sites[] = $site;
                                }
                            }

                            foreach($sites as $row){
                        ?>
                            <div class="sites">
                                <form action="./single.php" method="post" id="site">
                                    <input type="hidden" name="site_id" value=<?= $row['site_id'] ?>>
                                    <input type="hidden" name="site_name" value=<?= $row['site_name'] ?>>
                                    <input type="hidden" name="site_url" value=<?= $row['site_url'] ?>>
                                </form>
                                <span class="site-name"><?= $row['site_name'] ?></span>
                                <span class="site-count"><?= $row['count'] ?> Accounts</span>
                            </div>
                        <?php
                        }
                        ?>
                        <script>
                            const sites = document.querySelectorAll(".sites");

                            sites.forEach(site => {
                                const form = site.querySelector("#site");
                                site.addEventListener('click', function() {
                                    form.submit();
                                });
                            });
                        </script>
                </div>
            </div>
        </main>
    </div>
<?PHP include './includes/footer.php' ?>