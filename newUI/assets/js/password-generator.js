// document.addEventListener('DOMContentLoaded', () => {
//     // Initialize elements
//     const lengthSlider = document.getElementById('lengthSlider');
//     const lengthValue = document.getElementById('lengthValue');
//     const uppercaseCheckbox = document.getElementById('uppercase');
//     const lowercaseCheckbox = document.getElementById('lowercase');
//     const numbersCheckbox = document.getElementById('numbers');
//     const symbolsCheckbox = document.getElementById('symbols');
//     const generateBtn = document.getElementById('generateBtn');
//     const copyBtn = document.getElementById('copyBtn');
//     const generatedPassword = document.getElementById('generatedPassword');
//
//     // Update length value display
//     lengthSlider.addEventListener('input', () => {
//         lengthValue.textContent = lengthSlider.value;
//     });
//
//     // Generate password
//     generateBtn.addEventListener('click', generatePasswordOnClick);
//
//     // Generate a password on page load
//     generatePasswordOnClick();
//
//     // Copy password to clipboard
//     copyBtn.addEventListener('click', () => {
//         if (!generatedPassword.value) {
//             alert('Please generate a password first');
//             return;
//         }
//
//         generatedPassword.select();
//         document.execCommand('copy');
//     });
//
//     // Function to handle password generation
//     function generatePasswordOnClick() {
//         const length = parseInt(lengthSlider.value);
//         const options = {
//             uppercase: uppercaseCheckbox.checked,
//             lowercase: lowercaseCheckbox.checked,
//             numbers: numbersCheckbox.checked,
//             symbols: symbolsCheckbox.checked
//         };
//
//         // Validate at least one option is selected
//         if (!Object.values(options).some(Boolean)) {
//             alert('Please select at least one character type');
//             return;
//         }
//
//         const password = generatePassword(length, options);
//         generatedPassword.value = password;
//     }
//
//     // Generate password function
//     function generatePassword(length, options) {
//         const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
//         const lowercase = 'abcdefghijklmnopqrstuvwxyz';
//         const numbers = '0123456789';
//         const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
//
//         let chars = '';
//         if (options.uppercase) chars += uppercase;
//         if (options.lowercase) chars += lowercase;
//         if (options.numbers) chars += numbers;
//         if (options.symbols) chars += symbols;
//
//         let password = '';
//         for (let i = 0; i < length; i++) {
//             const randomIndex = Math.floor(Math.random() * chars.length);
//             password += chars[randomIndex];
//         }
//
//         // Ensure at least one character from each selected type
//         if (options.uppercase && !/[A-Z]/.test(password)) {
//             password = password.slice(0, -1) + uppercase[Math.floor(Math.random() * uppercase.length)];
//         }
//         if (options.lowercase && !/[a-z]/.test(password)) {
//             password = password.slice(0, -1) + lowercase[Math.floor(Math.random() * lowercase.length)];
//         }
//         if (options.numbers && !/[0-9]/.test(password)) {
//             password = password.slice(0, -1) + numbers[Math.floor(Math.random() * numbers.length)];
//         }
//         if (options.symbols && !/[^A-Za-z0-9]/.test(password)) {
//             password = password.slice(0, -1) + symbols[Math.floor(Math.random() * symbols.length)];
//         }
//
//         return password;
//     }
// });