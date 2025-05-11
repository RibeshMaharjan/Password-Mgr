<?php include_once './lib/passwordGenerator.php'; ?>
<?php require './includes/header.php'; ?>
<?php require './includes/nav.php'; ?>
    <style>
            /* Custom styles for checkbox */
            input[type="checkbox"] {
                accent-color: black;
                width: 16px;
                height: 16px;
            }

            /* Center the generated password */
            #generatedPassword {
                text-align: center;
                font-family: monospace;
            }

            input[type="range"] {
                accent-color: black;
            }



        </style>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <?php
            $password = '';

            if(isset($_POST["generate"]))
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
        ?>
        <div class="container mx-auto p-4 max-w-2xl">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-bold mb-6">Password Generator</h2>
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

                <div class="space-y-6">
                    <!-- Length Slider -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Password Length: <span id="lengthValue">12</span></label>
                        <div class="slider-container mt-3 mb-3">
                            <input type="range" name="length" id="lengthSlider" min="8" max="32" value="12" class="w-full">
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="uppercase" id="uppercase" checked class="w-4 h-4 border-gray-300 rounded">
                            <label for="uppercase" class="text-sm">Include Uppercase Letters</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="lowercase" id="lowercase" checked class="w-4 h-4 border-gray-300 rounded">
                            <label for="lowercase" class="text-sm">Include Lowercase Letters</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="number" id="numbers" checked class="w-4 h-4 border-gray-300 rounded">
                            <label for="numbers" class="text-sm">Include Numbers</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="symbol" id="symbols" checked class="w-4 h-4 border-gray-300 rounded">
                            <label for="symbols" class="text-sm">Include Symbols</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <!-- Generate Button -->
                        <button id="generateBtn" type="submit" name="generate" class="w-full h-9 bg-black text-white text-sm rounded-md px-4 py-2 transition-all duration-200 hover:bg-gray-800">
                            Generate Password
                        </button>
                        <button id="copyBtn" onclick="copyField('generatedPassword')" class="ml-2 border h-9 border-gray-300 bg-white rounded-md px-4 py-2 text-sm hover:bg-gray-50 transition-all duration-200">
                            Copy
                        </button>
                    </div>
                </form>

                    <div class="mt-4">
                        <input value="<?= $password ?? '' ?>" type="text" id="generatedPassword" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive font-mono text-center" readonly>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        const lengthSlider = document.getElementById('lengthSlider');
        const lengthValue = document.getElementById('lengthValue');

        // Update length value display
        lengthSlider.addEventListener('input', () => {
           lengthValue.textContent = lengthSlider.value;
        });

        function copyField(fieldId) {
            const input = document.getElementById(fieldId);
            input.select();
            document.execCommand('copy');
        }

    </script>

<?php require './includes/footer.php'; ?>