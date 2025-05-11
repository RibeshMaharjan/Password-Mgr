<?php require './includes/footer.php'; ?>

    <div class="w-full max-w-md w-full space-y-8 px-3 py-8 bg-white rounded-xl shadow-lg">

        <div class="card border-0 shadow-none">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">KeyNest</h1>
                <p class="text-gray-600 mt-2">Verify your email</p>
            </div>
            <form id="loginForm" class="space-y-4">
                <div>
                    <!-- <label class="block text-sm font-medium mb-1">Email</label> -->
                    <input type="email" name="verification_code" class="form-input h-9 shadow-sm" placeholder="Verification Code" required>
                </div>
                <div class="flex items-center justify-end">
                    <a href="#" class="text-sm text-gray-900 hover:underline">Resend Code</a>
                </div>
                <button type="submit" class="h-9 bg-black rounded-md text-white text-sm px-4 py-2 hover:bg-gray-800 transition-all duration-200 w-full">Verify</button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Return to
                    <a href="#" class="text-gray-900 hover:underline" id="showRegister">Login</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html> 