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
                        <div class="credential-info-group">
                            <label for="username">Username</label>
                            <input type="text" value="<?= $row['username'] ?>">
                        </div>
                        <div class="credential-info-group">
                            <label for="password">Password</label>
                            <input type="" value="<?= $row['password'] ?>">
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
        <script>
            // const sites = document.querySelectorAll(".sites");

            // sites.forEach(site => {
            //     const form = site.querySelector("#site");
            //     site.addEventListener('click', function() {
            //         // document.forms['form-delete'];
            //         form.submit();  
            //     });
            // });
        </script>
</div>