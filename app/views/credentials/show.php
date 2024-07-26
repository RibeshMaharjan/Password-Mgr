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
                    <td style="display: none;"><?= $row["id"]; ?></td>
                    <td scope="row"><?= $row['site']; ?></td>
                    <td><?= $row["username"]; ?></td>
                    <td><?= $row["password"]; ?></td>
                    <td class="table-cell">
                        <!-- Button trigger modal -->
                        <button type="button" class="table-btn" id="edit-btn" data-bs-toggle="modal" data-bs-target="#credential-edit">
                        Edit
                        </button>
                        <a href="../app/controllers/credential.php?delete=<?=$row['id']?>" class="table-btn">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
                </tr>
            </tbody>
        </table>