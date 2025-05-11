<?php

if(!isset($_SESSION['auth']))
{
   header('Location: ./login.php');
}

if(!checkVerification()) {
    header('Location: ./emailVerification.php');
}

?>
<header class="primary-header">
                <div>
                    <img src="./assets/images/logo/logo2preview.png" alt="" class="logo">
                </div>

                <button class="mobile-nav-toggle" aria-expanded="false">
                </button>

                <nav>
                    <ul id="primary-navigation" class="primary-navigation" data-visible="false">
                        <li class="active">
                            <a href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="./passwordgenerator.php">
                                Password Generator
                            </a>
                        </li>
                        <li>
                            <a href="./userprofile.php">
                                Profile
                            </a>
                        </li>
                        <li>
                        <form action="logout.php" method="POST" id="logout-form">
                            <input type="hidden" name="logout">
                            <a href="" onclick="submitLogoutForm(event)">
                                Logout
                            </a>
                        </form>
                        </li>
                        <script>
                            function submitLogoutForm(event) {
                                event.preventDefault();
                                document.getElementById("logout-form").submit();
                            }
                        </script>
                    </ul>
                </nav>
            </header>
            <div class="content">