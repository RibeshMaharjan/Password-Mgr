<?php
    
    require_once '../app/config/dbh.php';
    require_once '../app/helpers/session_helper.php';
    include "../app/models/credential.php";
    include "../app/controllers/credential.php";

    $credential = new CredentialController();

    $data = $credential->showCredentials();
?>
<div
    class="table-responsive"
>
    <table
        class="table table-primary"
    >
        <thead>
            <tr>
                <th scope="col">Site</th>
                <th scope="col">Username</th>
                <th scope="col">Passowrd</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                while($row = $data->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr class="">
                <td scope="row"><?= $row["site"]; ?></td>
                <td><?= $row["username"]; ?></td>
                <td><?= $row["password"]; ?></td>
                <td><a href="">Edit</a><a href="">Delete</a></td>
            </tr>
            <?php
                }
            ?>
            </tr>
        </tbody>
    </table>
</div>