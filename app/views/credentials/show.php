<?php if(isset($data['message'])){
    echo $data['message'];
} ?>
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
            foreach ($data as $row) {
                // while($row = $data->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr class="">
                <td scope="row"><?= $row['site']; ?></td>
                <td><?= $row["username"]; ?></td>
                <td><?= $row["password"]; ?></td>
                <td><a href="">Edit</a><br><a href="../app/controllers/credential.php?delete=<?=$row['id']?>">Delete</a></td>
            </tr>
            <?php
                }
            ?>
            </tr>
        </tbody>
    </table>
</div>