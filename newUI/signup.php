<?php
require_once './helpers/session_helper.php';
require_once './php/dbh.php';
?>

<?php require './includes/header.php'; ?>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-full max-w-md w-full space-y-8 px-3 py-8 bg-white rounded-xl shadow-lg">

        <!-- Register Form (Hidden by default) -->
        <div id="registerForm" class="card shadow-none mt-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">KeyNest</h1>
                <p class="text-gray-600 mt-2">Create your new account</p>
            </div>
            <form action="php/validate.php" method="post" class="space-y-4">
                <!-- Alert Message-->
                <?php
                    if(isset($_SESSION['error'])) {
                        echo '
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                              <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                              </svg>
                              <span class="sr-only">Info</span>
                              <div>
                                '.$_SESSION['error'].'
                              </div>
                            </div>
                        ';
                        unset($_SESSION['error']);
                    }
                    if(isset($_SESSION['message'])) {
                        echo '
                            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                              <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                              </svg>
                              <span class="sr-only">Info</span>
                              <div>
                                '.$_SESSION['message'].'
                              </div>
                            </div>
                        ';
                        unset($_SESSION['message']);
                    }
                ?>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Name</label> -->
                    <input type="text" name="fullname" class="form-input h-9 shadow-sm" placeholder="Full Name" value="<?= $_SESSION['fullname'] ?? '' ?>" >
                    <span class="text-red-600 text-sm font-semibold italic"><?= $_SESSION['formError']['fullname'] ?? '' ?></span>
                    <?php if(isset($_SESSION['formError']['fullname'])) unset($_SESSION['formError']['fullname']); ?>
                    <?php if(isset($_SESSION['fullname'])) unset($_SESSION['fullname']); ?>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Name</label> -->
                    <input type="text" name="uname" class="form-input h-9 shadow-sm" placeholder="Username" value="<?= $_SESSION['uname'] ?? '' ?>" >
                    <span class="text-red-600 text-sm font-semibold italic"><?= $_SESSION['formError']['uname'] ?? '' ?></span>
                    <?php if(isset($_SESSION['formError']['uname'])) unset($_SESSION['formError']['uname']); ?>
                    <?php if(isset($_SESSION['uname'])) unset($_SESSION['uname']); ?>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Email</label> -->
                    <input type="email" name="email" class="form-input h-9 shadow-sm" placeholder="Email" value="<?= $_SESSION['email'] ?? '' ?>" >
                    <span class="text-red-600 text-sm font-semibold italic"><?= $_SESSION['formError']['email'] ?? '' ?></span>
                    <?php if(isset($_SESSION['formError']['email'])) unset($_SESSION['formError']['email']); ?>
                    <?php if(isset($_SESSION['email'])) unset($_SESSION['email']); ?>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Password</label> -->
                    <input type="password" name="password" class="form-input h-9 shadow-sm" placeholder="Password" >
                    <span class="text-red-600 text-sm font-semibold italic"><?= $_SESSION['formError']['password'] ?? '' ?></span>
                    <?php if(isset($_SESSION['formError']['password'])) unset($_SESSION['formError']['password']); ?>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Confirm Password</label> -->
                    <input type="password" name="confirmPassword" class="form-input h-9 shadow-sm" placeholder="Confirm Password" >
                    <span class="text-red-600 text-sm font-semibold italic"><?= $_SESSION['formError']['confirmPassword'] ?? '' ?></span>
                    <?php if(isset($_SESSION['formError']['confirmPassword'])) unset($_SESSION['formError']['confirmPassword']); ?>
                </div>
                <button type="submit" name="register" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200 w-full">Register</button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="./login.php" class="text-gray-900 hover:underline" id="showLogin">Sign In</a>
                </p>
            </div>
        </div>
    </div>
<?php require './includes/footer.php'; ?>