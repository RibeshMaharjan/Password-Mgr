<?php if(isset($data['message'])){
    echo $data['message'];
} ?>
<div class="update-history-row" data-visible="false">
 <?php 
        foreach ($data as $row) {
        // while($row = $data->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="dashboard-table-row-indent">
        <div class="dashboard-table-cell" id="accound-id"><?= $row["account_id"]; ?></div>
        <div class="dashboard-table-cell" id="site">site</div>
        <div class="dashboard-table-cell" id="username"><?= $row['previous_username']; ?></div>
        <div class="dashboard-table-cell" id="password"><?= $row['password']; ?></div>
        <div class="dashboard-table-cell">
            <!-- Button trigger modal -->
            <!-- <button type="button" class="table-btn edit-btn" id="edit-btn">
                Edit
            </button> -->
        </div>
        <div class="dashboard-table-cell option-cell">
            <!-- <div class="dropdown-icon">
                <i class="fa-solid fa-ellipsis"></i>
            </div>
            <ul class="option-dropdown-menu" data-visible="false">
                <li >Update History</li>
                <li class="delete-btn" id="delete-btn" data-bs-toggle="modal" data-bs-target="#credential-delete">Delete</li>
            </ul> -->
        </div>
    </div>
    <?php }
?>
</div>