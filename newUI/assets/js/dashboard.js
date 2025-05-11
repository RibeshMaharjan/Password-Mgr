// document.addEventListener('DOMContentLoaded', () => {
//     // Initialize elements
//     const addPasswordBtn = document.getElementById('addPasswordBtn');
//     const addPasswordModal = document.getElementById('addPasswordModal');
//     const addPasswordForm = document.getElementById('addPasswordForm');
//     const cancelAddPassword = document.getElementById('cancelAddPassword');
//     // const passwordList = document.getElementById('passwordList');
//     // const importPasswordsBtn = document.getElementById('importPasswordsBtn');
//     // const exportPasswordsBtn = document.getElementById('exportPasswordsBtn');
//     // const importExportModal = document.getElementById('importExportModal');
//     // const importExportForm = document.getElementById('importExportForm');
//     // const cancelImportExport = document.getElementById('cancelImportExport');
//     const modalTitle = document.getElementById('modalTitle');
//     // const dashboardView = document.getElementById('dashboardView');
//     // const passwordDetailView = document.getElementById('passwordDetailView');
//     // const backToDashboard = document.getElementById('backToDashboard');
//
//     // // Detail view elements
//     // const detailTitle = document.getElementById('detailTitle');
//     // const visitSiteBtn = document.getElementById('visitSiteBtn');
//     // const detailUsername = document.getElementById('detailUsername');
//     // const detailPassword = document.getElementById('detailPassword');
//     // const detailNotes = document.getElementById('detailNotes');
//     // const detailCreated = document.getElementById('detailCreated');
//     // const detailModified = document.getElementById('detailModified');
//     // const passwordHistory = document.getElementById('passwordHistory');
//
//     addPasswordBtn.addEventListener('click', () => {
//         addPasswordModal.classList.remove('hidden');
//     });
//
//     cancelAddPassword.addEventListener('click', () => {
//         addPasswordModal.classList.add('hidden');
//         addPasswordForm.reset();
//     });
//
//     // Handle form submissions
//     addPasswordForm.addEventListener('submit', (e) => {
//         e.preventDefault();
//         const formData = new FormData(addPasswordForm);
//         const now = new Date();
//         const newPassword = {
//             id: Date.now(),
//             title: formData.get('title'),
//             username: formData.get('username'),
//             password: formData.get('password'),
//             website: formData.get('website'),
//             createdAt: now.toISOString(),
//             modifiedAt: now.toISOString(),
//             notes: '',
//             history: [
//                 { password: '********', date: now.toISOString() }
//             ]
//         };
//
//         passwords.push(newPassword);
//         localStorage.setItem('passwords', JSON.stringify(passwords));
//         updatePasswordList();
//         updateStatistics();
//         addPasswordModal.classList.add('hidden');
//         addPasswordForm.reset();
//     });
//
//
//     // Helper function to format dates
//     function formatDate(date) {
//         return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
//     }
//
//     function isWeakPassword(password) {
//         return password.length < 8 ||
//                !/[A-Z]/.test(password) ||
//                !/[a-z]/.test(password) ||
//                !/[0-9]/.test(password) ||
//                !/[^A-Za-z0-9]/.test(password);
//     }
//
//     function findReusedPasswords() {
//         const passwordMap = new Map();
//         passwords.forEach(p => {
//             if (!passwordMap.has(p.password)) {
//                 passwordMap.set(p.password, []);
//             }
//             passwordMap.get(p.password).push(p);
//         });
//         return Array.from(passwordMap.values()).filter(arr => arr.length > 1);
//     }
//
//     function calculateSecurityScore() {
//         if (passwords.length === 0) return 100;
//
//         const weakPasswordPenalty = passwords.filter(p => isWeakPassword(p.password)).length * 10;
//         const reusedPasswordPenalty = findReusedPasswords().length * 15;
//         const totalPenalty = weakPasswordPenalty + reusedPasswordPenalty;
//
//         return Math.max(0, 100 - totalPenalty);
//     }
// });
//
// // Global functions for password actions
// function copyPassword(id) {
//     const input = document.getElementById(`password-${id}`);
//     input.select();
//     document.execCommand('copy');
//     alert('Password copied to clipboard!');
// }
//
// function togglePassword(id) {
//     const input = document.getElementById(`password-${id}`);
//     if (input.classList.contains('hidden')) {
//         input.classList.remove('hidden');
//         input.type = 'text';
//         setTimeout(() => {
//             input.classList.add('hidden');
//             input.type = 'password';
//         }, 3000); // Hide after 3 seconds
//     } else {
//         input.type = input.type === 'password' ? 'text' : 'password';
//     }
// }
//
// function toggleDetailPassword() {
//     const input = document.getElementById('detailPassword');
//     input.type = input.type === 'password' ? 'text' : 'password';
// }
//
// function copyDetail(elementId) {
//     const input = document.getElementById(elementId);
//     input.select();
//     document.execCommand('copy');
//     alert('Copied to clipboard!');
// }
//
// function deletePassword(id) {
//     if (confirm('Are you sure you want to delete this password?')) {
//         let passwords = JSON.parse(localStorage.getItem('passwords')) || [];
//         passwords = passwords.filter(p => p.id != id);
//         localStorage.setItem('passwords', JSON.stringify(passwords));
//
//         // Update UI
//         const dashboardView = document.getElementById('dashboardView');
//         const passwordDetailView = document.getElementById('passwordDetailView');
//
//         // Show dashboard if we're in detail view
//         if (!passwordDetailView.classList.contains('hidden')) {
//             passwordDetailView.classList.add('hidden');
//             dashboardView.classList.remove('hidden');
//         }
//
//         updatePasswordList();
//         updateStatistics();
//     }
// }