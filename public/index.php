<?php include './includes/header.php'; ?>
    <main>
        <h3>Enter your Credentials</h3>
        <form action="../app/controllers/credential.php" class="signup_form" method="POST">
            <!-- Site Input -->
            <div>                    
                <input type="text" class="input" name="site" placeholder="Site"><br>
            </div>  
            <!-- Name Input -->
            <div>                    
                <input type="text" class="input" name="username" placeholder="UserName"><br>
            </div>                    
            <!-- Password Input -->
            <div>                    
                <input type="password" class="input" name="password" placeholder="Password"><br>
            </div>
            <!-- Add Button -->
            <button type="submit" name="add">Register</button>
        </form><br><br>
        <h1>Update Form</h1>
        <form action="../app/controllers/credential.php" class="signup_form" method="POST">
            <div>                    
                <input type="text" class="input" name="id" placeholder="Id"><br>
            </div>
            <!-- Site Input -->
            <div>                    
                <input type="text" class="input" name="site" placeholder="Site"><br>
            </div>  
            <!-- Name Input -->
            <div>                    
                <input type="text" class="input" name="username" placeholder="UserName"><br>
            </div>                    
            <!-- Password Input -->
            <div>                    
                <input type="password" class="input" name="password" placeholder="Password"><br>
            </div>
            <!-- Add Button -->
            <button type="submit" name="update">Register</button>
        </form><br><br>
        <div class="container ms-0">
            <h3>Your Credentials</h3>
            <?php 
                $credential = new Credential();
                $data = $credential->showCredentials(); 
            ?>
        </div>
    </main>
<?PHP include './includes/footer.php' ?>