<?php
require_once './helpers/session_helper.php';

// If user is already logged in, redirect to dashboard
if(isset($_SESSION['auth'])) {
    header('Location: ./index.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Password Manager - Secure Password Storage Solution</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="A secure password manager that allows you to store and manage your passwords safely." />
        
        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <!-- Tomorrow Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
            rel="stylesheet">
        <!-- Montserrat Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" 
            rel="stylesheet">

        <!-- Poppins Font -->
        <link 
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
            rel="stylesheet">

        <!-- Font Awesome Cdn -->
        <script 
            src="https://kit.fontawesome.com/922cd10ce2.js" 
            crossorigin="anonymous">
        </script>

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <!-- Main Css -->
        <link rel="stylesheet" href="./assets/css/styles.css">
        
        <style>
            /* Additional styles for landing page */
            .hero-section {
                min-height: 80vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 2rem;
            }
            
            .hero-title {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                color: #ffffff;
            }
            
            .hero-subtitle {
                font-size: 1.5rem;
                margin-bottom: 2rem;
                color: #ffffff;
                max-width: 800px;
            }
            
            .hero-buttons {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }
            
            .hero-button {
                padding: 0.8rem 2rem;
                font-size: 1.2rem;
                border-radius: 30px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
            }
            
            .hero-button:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
            
            .primary-button {
                background-color: #008080;
                color: white;
                border: none;
            }
            
            .secondary-button {
                background-color: transparent;
                color: white;
                border: 2px solid white;
            }
            
            .features-section {
                padding: 4rem 2rem;
                background-color: rgba(29, 40, 60, 0.9);
                border-radius: 10px;
                margin: 0 auto 4rem;
                max-width: 1200px;
            }
            
            .features-title {
                text-align: center;
                color: white;
                margin-bottom: 3rem;
            }
            
            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }
            
            .feature-card {
                background-color: rgba(16, 24, 39, 0.8);
                padding: 2rem;
                border-radius: 10px;
                text-align: center;
                transition: transform 0.3s ease;
            }
            
            .feature-card:hover {
                transform: translateY(-10px);
            }
            
            .feature-icon {
                font-size: 2.5rem;
                color: #008080;
                margin-bottom: 1rem;
            }
            
            .feature-title {
                font-size: 1.5rem;
                color: white;
                margin-bottom: 1rem;
            }
            
            .feature-description {
                color: #e0e0e0;
            }
            
            .landing-footer {
                text-align: center;
                padding: 2rem;
                color: white;
                background-color: rgba(16, 24, 39, 0.8);
                margin-top: 2rem;
            }
            
            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }
                
                .hero-subtitle {
                    font-size: 1.2rem;
                }
                
                .hero-buttons {
                    flex-direction: column;
                }
            }
        </style>
    </head>
    <body>
        <header class="primary-header">
            <div>
                <img src="./assets/images/logo/logo2preview.png" alt="Password Manager Logo" class="logo">
            </div>
            
            <button class="mobile-nav-toggle" aria-expanded="false"></button>
            
            <nav>
                <ul id="primary-navigation" class="primary-navigation" data-visible="false">
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="signup.php">Sign Up</a>
                    </li>
                </ul>
            </nav>
        </header>
        
        <div class="content">
            <section class="hero-section">
                <h1 class="hero-title">Secure Password Manager</h1>
                <p class="hero-subtitle">
                    Store and manage your passwords securely with our advanced encryption technology.
                    Never forget a password again!
                </p>
                <div class="hero-buttons">
                    <a href="signup.php" class="hero-button primary-button">Get Started</a>
                    <a href="login.php" class="hero-button secondary-button">Login</a>
                </div>
            </section>
            
            <section class="features-section">
                <h2 class="features-title">Key Features</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h3 class="feature-title">Secure Storage</h3>
                        <p class="feature-description">
                            All your passwords are encrypted using AES algorithm to ensure maximum security.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <h3 class="feature-title">Password Generator</h3>
                        <p class="feature-description">
                            Create strong, unique passwords with our built-in password generator.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h3 class="feature-title">User-Friendly</h3>
                        <p class="feature-description">
                            Easy to use interface to manage all your passwords in one place.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h3 class="feature-title">Add & Edit</h3>
                        <p class="feature-description">
                            Easily add, edit, and delete your password entries as needed.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="feature-title">Profile Management</h3>
                        <p class="feature-description">
                            Manage your profile information and account settings.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="feature-title">Data Protection</h3>
                        <p class="feature-description">
                            Your data is protected with industry-standard security measures.
                        </p>
                    </div>
                </div>
            </section>
            
            <footer class="landing-footer">
                <p>&copy; <?php echo date("Y"); ?> Password Manager. All rights reserved.</p>
            </footer>
        </div>
        
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <!-- Jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="./assets/js/nav.js"></script>
    </body>
</html>