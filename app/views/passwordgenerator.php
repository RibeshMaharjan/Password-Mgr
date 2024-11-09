<?php

    // session_start();

    if(isset($data['message'])){
        echo $data['message'];
    }

    $password = '';
    if (isset($_POST["generate"])) 
    {
        // Grabbing the data
        $length = $_POST["length"];
        $lowercase = isset($_POST["lowercase"]) ? true : false;
        $uppercase = isset($_POST["uppercase"]) ? true : false;
        $number = isset($_POST["number"]) ? true : false;
        $symbols = isset($_POST["symbol"]) ? true : false;

        $selectedOptions = [$lowercase, $uppercase, $number, $symbols];
        $countSelected = count(array_filter($selectedOptions));

        if($countSelected < 2){
            $_SESSION['message'] = "Select at least Two";
        }
        if(!$lowercase || !$uppercase || !$number || !$symbols) {
            $_SESSION['alert'] = "Your password isn't strong enough";
        } 
        if($countSelected >= 2 && ($lowercase || $uppercase || $number || $symbols)) {
            $password = generatePasswords($length, $lowercase, $uppercase, $number, $symbols);
        }

    }

    function generatePasswords($length, $lowercase, $uppercase, $number, $symbols) {
        $password = '';
        $includeLowercase = $lowercase;
        $includeUppercase = $uppercase;
        $includeNumbers = $number;
        $includesymbols = $symbols;

        $allowedChars = array();
        $allowedChar = "";
        $lower_case = "abcdefghijklmnopqrstuvwxyz";
        $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $num = "1234567890";
        $special_symbol = "!@#$%^&*~";

        if($includeLowercase) { $allowedChars[] = $lower_case; }
        if($includeUppercase) { $allowedChars[] = $upper_case; }
        if($includeNumbers) { $allowedChars[] = $num; }
        if($includesymbols) { $allowedChars[] = $special_symbol; }

        
        foreach($allowedChars as $chars){
            $password .= $chars[array_rand(str_split($chars))];
            $allowedChar .= $chars;
        }

        $allowedChar = str_split($allowedChar);
        for($i = count($allowedChars); $i < $length; $i++){
            $password .= $allowedChar[array_rand($allowedChar)];
        }
        $password = str_shuffle($password);
      
        $add_dashes = true;
        if(!$add_dashes)
		    return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;

        return $dash_str;
    }
?>

<div class="password-container">
    <span class="password"><?= $password ?></span>
    <div class="copy-icon copy-btn" onclick="copyToClipboard(event)">
        <i class="fa-solid fa-copy"></i>
    </div>
    <script>
        function copyToClipboard(event) {
            const inputContainer = event.target.closest(".password-container");
            const inputField = inputContainer.querySelector("span");
            copyText = inputField.innerText;
            navigator.clipboard.writeText(copyText);  
        }
    </script>
</div>
<?php

    if(isset($_SESSION['message']) || isset($_SESSION['alert'])) {
        echo '
            <div class="notifications-container">
            <div class="error-alert">
                    <i class="fa-solid fa-circle-xmark weak-icon"></i>
                    <i class="fa-solid fa-circle-check strong-icon"></i>
                    <div class="error-prompt-container">
                        <p class="error-prompt-heading">';
                        if (isset($_SESSION['alert'])) {
                            echo $_SESSION['alert'];  // Display the alert message
                            unset($_SESSION['alert']); // Clear the alert after displaying
                        }
                        echo '</p>
                        <div class="error-prompt-wrap">
                            <ul class="error-prompt-list" role="list">';
                            if (isset($_SESSION['message'])) {
                                echo '<li id="selectedOption">'. $_SESSION['message'] .'</li>';  // Display the alert message
                                unset($_SESSION['message']); // Clear the alert after displaying
                            }
                            echo '
                            </ul>
                        </div>
                    </div>
            </div>
            </div> 
        ';
    }
?>

<form action="" method="POST" class="generator-form">
    <input type="hidden" name="userid" value="">
    <div class="generator-form-input-group">
        <label for="length">
            Length
            <input type="number" name="length" onchange="checkLength(event)" min="8" value="8" id="length">
        </label>
        <p id="length" style="display: none;">Password must be at least 8 characters</p>
    </div>
    <div class="generator-form-input-group">
        <label for="lowercase" >
            Lowercase
            <div class="checkBox">
                <input type="checkbox" name="lowercase" onchange="checkSelected(event)" id="lowercase">
                <div class="transition"></div>
            </div>
        </label>
        <p id="lowercase">Include lowercase letters for complexity.</p>
    </div>
    <div class="generator-form-input-group">
        <label for="uppercase">
            Uppercase
            <div class="checkBox">
                <input type="checkbox" name="uppercase" onchange="checkSelected(event)" id="uppercase">
                <div class="transition"></div>
            </div>
        </label>
        <p id="uppercase">Include uppercase letters for added strength.</p>

    </div>
    <div class="generator-form-input-group">
        <label for="number">
            Numbers
            <div class="checkBox">
                <input type="checkbox" name="number" onchange="checkSelected(event)" id="number">
                <div class="transition"></div>
            </div>
        </label>
        <p id="number">Include numbers for unpredictability.</p>
    </div>
    <div class="generator-form-input-group">
        <label for="symbol">
            Symbols
            <div class="checkBox">
                <input type="checkbox" name="symbol" onchange="checkSelected(event)" id="symbol">
                <div class="transition"></div>
            </div>
        </label>
        <p id="alert">Include symbols for better security.</p>
    </div>
    <button class="pass-mgr-button" type="submit" name="generate">Generate Password</button>
</form>

<script>
   
    function checkSelected(e) {
        const container = e.target.closest("label").closest("div");       
        const alertMessage = container.querySelector("p");

        if (e.target.checked) {
            alertMessage.style.display = "none";
        } else {
            alertMessage.style.display = "block";
        }
    }

    function checkLength(e){
        // const pwlength = form.querySelector("input[type='number']");
        const container = e.target.closest("div");
        const passlength = container.querySelector("input[type='number']");
        const alertMessage = container.querySelector("p");
        console.log(passlength.value);
        
        if(passlength.value < 8 ){
            alertMessage.style.display = "block";
        }else {
            alertMessage.style.display = "none";
        }
    }

</script>