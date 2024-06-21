<?php
    
    

    
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
                // while($row = $data->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr class="">
                <td scope="row"><?= $data[0]['site']; ?></td>
                <td><?= $data[0]["username"]; ?></td>
                <td><?= $data[0]["password"]; ?></td>
                <td><a href="">Edit</a><a href="">Delete</a></td>
            </tr>
            <?php
                // }
            ?>
            </tr>
        </tbody>
    </table>
</div>