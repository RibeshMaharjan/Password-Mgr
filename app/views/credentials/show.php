<?php if(isset($data['message'])){
    echo $data['message'];
} ?>

        <table class="table align-middle">
            <thead>
                <tr>
                <th scope="col">Site</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($data as $row) {
                    // while($row = $data->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr class="">
                    <td style="display: none;" id="id"><?= $row["account_id"]; ?></td>
                    <td scope="row" id="site"><?= $row['site']; ?></td>
                    <td id="username"><?= $row["username"]; ?></td>
                    <td id="password"><?= $row["password"]; ?></td>
                    <td class="table-cell">
                        <!-- Button trigger modal -->
                        <button type="button" class="table-btn edit-btn" id="edit-btn">
                        Edit
                        </button>
                        <button type="button" class="table-btn delete-btn" id="delete-btn">Delete</button>
                    </td>
                </tr>
                <?php
                    }
                ?>
                </tr>
            </tbody>
        </table>