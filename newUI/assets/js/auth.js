// // Check if user is logged in
// function isLoggedIn() {
//     return localStorage.getItem('user') !== null;
// }

// // Handle logout
// document.getElementById('logoutBtn')?.addEventListener('click', () => {
//     localStorage.removeItem('user');
//     window.location.href = 'login.php';
// });

// // Check authentication on page load
// document.addEventListener('DOMContentLoaded', () => {
//     if (!isLoggedIn() && !window.location.pathname.includes('login.php')) {
//         window.location.href = 'login.php';
//     }
// }); 