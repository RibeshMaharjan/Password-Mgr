// document.addEventListener('DOMContentLoaded', () => {
//     const loginForm = document.getElementById('loginForm');
//     const registerForm = document.getElementById('registerForm');
//     const showRegisterBtn = document.getElementById('showRegister');
//     const showLoginBtn = document.getElementById('showLogin');
//
//     // Toggle between login and register forms
//     showRegisterBtn.addEventListener('click', (e) => {
//         e.preventDefault();
//         loginForm.parentElement.classList.add('hidden');
//         registerForm.classList.remove('hidden');
//     });
//
//     showLoginBtn.addEventListener('click', (e) => {
//         e.preventDefault();
//         registerForm.classList.add('hidden');
//         loginForm.parentElement.classList.remove('hidden');
//     });
//
//     // Handle login form submission
//     loginForm.addEventListener('submit', (e) => {
//         e.preventDefault();
//         const formData = new FormData(loginForm);
//         const email = formData.get('email');
//         const password = formData.get('password');
//         const remember = formData.get('remember');
//
//         // In a real app, this would make an API call to verify credentials
//         // For demo purposes, we'll use a simple check
//         const user = {
//             email,
//             name: email.split('@')[0], // Demo: use email username as name
//             password // In a real app, this would be hashed
//         };
//
//         // Save user data
//         localStorage.setItem('user', JSON.stringify(user));
//         if (remember) {
//             localStorage.setItem('rememberMe', 'true');
//         }
//
//         // Redirect to dashboard
//         window.location.href = 'dashboard.php';
//     });
//
//     // Handle register form submission
//     registerForm.querySelector('form').addEventListener('submit', (e) => {
//         e.preventDefault();
//         const formData = new FormData(e.target);
//         const name = formData.get('name');
//         const email = formData.get('email');
//         const password = formData.get('password');
//         const confirmPassword = formData.get('confirmPassword');
//
//         // Validate passwords
//         if (password !== confirmPassword) {
//             alert('Passwords do not match');
//             return;
//         }
//
//         // In a real app, this would make an API call to create the account
//         // For demo purposes, we'll just save the user data
//         const user = {
//             name,
//             email,
//             password // In a real app, this would be hashed
//         };
//
//         // Save user data
//         localStorage.setItem('user', JSON.stringify(user));
//
//         // Redirect to dashboard
//         window.location.href = 'dashboard.php';
//     });
//
//     // Check if user is already logged in
//     if (isLoggedIn()) {
//         window.location.href = 'dashboard.php';
//     }
// });