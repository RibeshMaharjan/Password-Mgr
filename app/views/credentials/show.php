<?php if(isset($data['message'])){
    echo $data['message'];
} ?>

<div class="dashboard-table">
    <div class="dashboard-table-head">
        <!-- <div class="dashboard-table-cell">Site</div> -->
        <div class="dashboard-table-cell">Username</div>
        <div class="dashboard-table-cell">Password</div>
        <div class="dashboard-table-cell">Notes</div>
        <div class="dashboard-table-cell">Actions To Take</div>
        <div class="dashboard-table-cell option-cell"></div>
    </div>
    <?php 
        foreach ($data as $row) {
        // while($row = $data->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="dashboard-table-row">
        <div class="current-credential-row">

            <div class="dashboard-table-cell" id="username"><?= $row['username']; ?></div>
            <div class="dashboard-table-cell" id="password"><?= $row['password']; ?></div>
            <div class="dashboard-table-cell" id="password"><?= $row['password']; ?></div>
            <div class="dashboard-table-cell">
                <!-- Button trigger modal -->
                <button type="button" class="pass-mgr-button table-btn edit-btn" id="edit-btn">
                    Edit
                </button>
            </div>
            <div class="dashboard-table-cell option-cell">
                <div class="dropdown-icon">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
                <ul class="option-dropdown-menu" data-visible="false">
                    <li class="update-history">Update History</li>
                    <li class="delete-btn" id="delete-btn" data-bs-toggle="modal" data-bs-target="#credential-delete">Delete</li>
                </ul>
            </div>
        </div>
        <?php 
            // $credential = new Credential();
            // $data = $credential->showCredentialsUpdateHistorys($row["account_id"]); 
        ?>
    </div>  
    <?php
        }
    ?>
</div>