<?php

if(!isset($_SESSION['auth']))
{
   header('Location: ./login.php');
   exit();
}

if(!checkVerification()) {
    header('Location: ./emailVerification.php');
    exit();
}

?>
<body class="min-h-screen bg-gray-50">
<!-- Header -->
<header class="h-16 border-b bg-white shadow-sm">
    <div class="h-full container mx-auto px-4">
        <div class="h-full flex justify-between items-center">
            <h1 class="text-2xl font-bold">KeyNest</h1>

            <nav class="flex items-center space-x-10">
                <a href="dashboard.php" class="nav-link text-sm font-medium transition-all duration-200 relative px-4 py-2 rounded-md">Dashboard</a>
                <a href="password-generator.php" class="nav-link text-sm font-medium transition-all duration-200 relative px-4 py-2 rounded-md">Password Generator</a>
                <a href="profile.php" class="nav-link text-sm font-medium transition-all duration-200 relative px-4 py-2 rounded-md">Profile</a>
            </nav>

<!--            <button id="logoutBtn" class="px-4 py-2 border rounded-md hover:bg-gray-100">Logout</button>-->
           <form action="logout.php" method="post" id="logout-form">
               <button id="logoutBtn" type="submit" name="logout" class="px-4 py-2 border rounded-md hover:bg-gray-100">Logout</button>
           </form>
        </div>
    </div>
</header>