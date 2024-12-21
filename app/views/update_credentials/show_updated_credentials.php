<?php if(isset($data['message'])){
    echo $data['message'];
} ?>
<div class="update-history-row" data-visible="false">
 <?php 
        foreach ($data as $row) {
    ?>
    <div class="dashboard-table-row-indent">
        <div class="dashboard-table-cell" id="accound-id"><?= $row["account_id"]; ?></div>
        <div class="dashboard-table-cell" id="site">site</div>
        <div class="dashboard-table-cell" id="username"><?= $row['previous_username']; ?></div>
        <div class="dashboard-table-cell" id="password"><?= $row['password']; ?></div>
        <div class="dashboard-table-cell">
        </div>
        <div class="dashboard-table-cell option-cell">
        </div>
    </div>
    <?php }
?>
</div>