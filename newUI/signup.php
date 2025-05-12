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
            <form class="space-y-4">
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Name</label> -->
                    <input type="text" name="name" class="form-input h-9 shadow-sm" placeholder="Name" required>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Email</label> -->
                    <input type="email" name="email" class="form-input h-9 shadow-sm" placeholder="Email" required>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Password</label> -->
                    <input type="password" name="password" class="form-input h-9 shadow-sm" placeholder="Password" required>
                </div>
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Confirm Password</label> -->
                    <input type="password" name="confirmPassword" class="form-input h-9 shadow-sm" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200 w-full">Register</button>
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