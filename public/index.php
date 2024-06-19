<?php

require_once '../app/helpers/session_helper.php';

echo $_SESSION["username"];

?>

<form action="../includes/credential-inc.php" class="signup_form" method="POST">
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
</form>