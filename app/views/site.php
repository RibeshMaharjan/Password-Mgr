<?php
    if(isset($data['message'])){
        echo $data['message'];
    }
?>
<div class="site-listing">
    <?php 
    foreach($data as $row){
        ?>
            <div class="sites">
                <form action="../public/single.php" method="post" id="site">
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