// document.addEventListener('DOMContentLoaded', () => {
//     // Tab handling
//     const tabButtons = document.querySelectorAll('.tab-btn');
//     const tabContents = document.querySelectorAll('.tab-content');
//
//     tabButtons.forEach(button => {
//         button.addEventListener('click', () => {
//             const tabId = button.dataset.tab;
//             // Update tab button styles
//             tabButtons.forEach(btn => {
//                 btn.classList.remove('active', 'bg-white', 'shadow');
//                 btn.classList.add('bg-transparent');
//             });
//             button.classList.add('active', 'bg-white', 'shadow');
//             button.classList.remove('bg-transparent');
//             // Show selected tab content
//             tabContents.forEach(content => {
//                 content.classList.add('hidden');
//                 if (content.id === tabId) {
//                     content.classList.remove('hidden');
//                 }
//             });
//         });
//     });
//
//     // Profile form logic
//     const profileForm = document.getElementById('profileForm');
//     const editProfileBtn = document.getElementById('editProfileBtn');
//     const nameInput = profileForm.elements['name'];
//     const emailInput = profileForm.elements['email'];
//     const usernameInput = profileForm.elements['username'];
//     const userAvatar = document.getElementById('userAvatar');
//     const verifyEmailBtn = document.getElementById('verifyEmailBtn');
//     const emailNotVerified = document.getElementById('emailNotVerified');
//
//     let editing = false;
//
//     // Load user data
//     function loadUser() {
//         const user = JSON.parse(localStorage.getItem('user') || '{}');
//         nameInput.value = user.name || '';
//         emailInput.value = user.email || '';
//         usernameInput.value = user.username || '';
//         // Avatar initial
//         userAvatar.textContent = user.name ? user.name[0].toUpperCase() : 'J';
//         // Email verification
//         if (user.emailVerified) {
//             emailNotVerified.classList.add('hidden');
//             verifyEmailBtn.classList.add('hidden');
//         } else {
//             emailNotVerified.classList.remove('hidden');
//             verifyEmailBtn.classList.remove('hidden');
//         }
//     }
//     loadUser();
//
//     // Edit/Save Profile toggle with separate Cancel and Save buttons
//     editProfileBtn.addEventListener('click', () => {
//         if (!editing) {
//             // Enable fields
//             nameInput.disabled = false;
//             emailInput.disabled = false;
//             usernameInput.disabled = false;
//
//             // Replace Edit button with Cancel and Save buttons
//             const buttonContainer = editProfileBtn.parentElement;
//             editProfileBtn.classList.add('hidden');
//
//             // Create buttons if they don't exist
//             if (!document.getElementById('cancelEditBtn')) {
//                 const cancelBtn = document.createElement('button');
//                 cancelBtn.type = 'button';
//                 cancelBtn.id = 'cancelEditBtn';
//                 cancelBtn.className = 'h-10 border border-gray-300 bg-white rounded-md text-black px-4 py-2 hover:bg-gray-100 transition-all duration-200 mr-2';
//                 cancelBtn.textContent = 'Cancel';
//
//                 const saveBtn = document.createElement('button');
//                 saveBtn.type = 'button';
//                 saveBtn.id = 'saveChangesBtn';
//                 saveBtn.className = 'h-10 bg-black rounded-md text-white px-4 py-2 hover:bg-gray-800 transition-all duration-200';
//                 saveBtn.textContent = 'Save Changes';
//
//                 buttonContainer.appendChild(cancelBtn);
//                 buttonContainer.appendChild(saveBtn);
//
//                 // Add event listeners to new buttons
//                 cancelBtn.addEventListener('click', cancelEditing);
//                 saveBtn.addEventListener('click', saveChanges);
//             } else {
//                 // Show existing buttons
//                 document.getElementById('cancelEditBtn').classList.remove('hidden');
//                 document.getElementById('saveChangesBtn').classList.remove('hidden');
//             }
//
//             editing = true;
//         }
//     });
//
//     function cancelEditing() {
//         // Disable fields
//         nameInput.disabled = true;
//         emailInput.disabled = true;
//         usernameInput.disabled = true;
//
//         // Hide Cancel and Save buttons, show Edit button
//         document.getElementById('cancelEditBtn').classList.add('hidden');
//         document.getElementById('saveChangesBtn').classList.add('hidden');
//         editProfileBtn.classList.remove('hidden');
//
//         // Reset form values
//         loadUser();
//
//         editing = false;
//     }
//
//     function saveChanges() {
//         // Save changes
//         const user = JSON.parse(localStorage.getItem('user') || '{}');
//         user.name = nameInput.value;
//         user.email = emailInput.value;
//         user.username = usernameInput.value;
//         localStorage.setItem('user', JSON.stringify(user));
//
//         // Disable fields
//         nameInput.disabled = true;
//         emailInput.disabled = true;
//         usernameInput.disabled = true;
//
//         // Hide Cancel and Save buttons, show Edit button
//         document.getElementById('cancelEditBtn').classList.add('hidden');
//         document.getElementById('saveChangesBtn').classList.add('hidden');
//         editProfileBtn.classList.remove('hidden');
//
//         editing = false;
//         loadUser();
//         alert('Profile updated successfully');
//     }
//
//     // Prevent form submit
//     profileForm.addEventListener('submit', e => e.preventDefault());
//
//     // Verify email button
//     verifyEmailBtn.addEventListener('click', () => {
//         alert('Verification email sent! (Demo only)');
//     });
//
//     // Security tab logic
//     const twoFactorToggle = document.getElementById('2faToggle');
//     const passwordForm = document.getElementById('passwordForm');
//
//     // Load 2FA state
//     const user = JSON.parse(localStorage.getItem('user') || '{}');
//     twoFactorToggle.checked = !!user.twoFactorEnabled;
//
//     twoFactorToggle.addEventListener('change', (e) => {
//         const enabled = e.target.checked;
//         const user = JSON.parse(localStorage.getItem('user') || '{}');
//         user.twoFactorEnabled = enabled;
//         localStorage.setItem('user', JSON.stringify(user));
//         alert(enabled ? 'Two-factor authentication enabled' : 'Two-factor authentication disabled');
//     });
//
//     // Change password form
//     passwordForm.addEventListener('submit', (e) => {
//         e.preventDefault();
//         const formData = new FormData(passwordForm);
//         const currentPassword = formData.get('currentPassword');
//         const newPassword = formData.get('newPassword');
//         const confirmPassword = formData.get('confirmPassword');
//         if (newPassword !== confirmPassword) {
//             alert('New passwords do not match');
//             return;
//         }
//         // In a real app, verify current password
//         const user = JSON.parse(localStorage.getItem('user') || '{}');
//         user.password = newPassword;
//         localStorage.setItem('user', JSON.stringify(user));
//         alert('Password updated successfully');
//         passwordForm.reset();
//     });
// });