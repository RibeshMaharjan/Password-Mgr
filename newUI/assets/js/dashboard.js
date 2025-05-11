document.addEventListener('DOMContentLoaded', () => {
    // Initialize elements
    const addPasswordBtn = document.getElementById('addPasswordBtn');
    const addPasswordModal = document.getElementById('addPasswordModal');
    const addPasswordForm = document.getElementById('addPasswordForm');
    const cancelAddPassword = document.getElementById('cancelAddPassword');
    const passwordList = document.getElementById('passwordList');
    const importPasswordsBtn = document.getElementById('importPasswordsBtn');
    const exportPasswordsBtn = document.getElementById('exportPasswordsBtn');
    const importExportModal = document.getElementById('importExportModal');
    const importExportForm = document.getElementById('importExportForm');
    const cancelImportExport = document.getElementById('cancelImportExport');
    const modalTitle = document.getElementById('modalTitle');
    const dashboardView = document.getElementById('dashboardView');
    const passwordDetailView = document.getElementById('passwordDetailView');
    const backToDashboard = document.getElementById('backToDashboard');

    // Detail view elements
    const detailTitle = document.getElementById('detailTitle');
    const visitSiteBtn = document.getElementById('visitSiteBtn');
    const detailUsername = document.getElementById('detailUsername');
    const detailPassword = document.getElementById('detailPassword');
    const detailNotes = document.getElementById('detailNotes');
    const detailCreated = document.getElementById('detailCreated');
    const detailModified = document.getElementById('detailModified');
    const passwordHistory = document.getElementById('passwordHistory');

    // Statistics elements
    const totalPasswordsEl = document.getElementById('totalPasswords');
    const weakPasswordsEl = document.getElementById('weakPasswords');
    const reusedPasswordsEl = document.getElementById('reusedPasswords');
    const securityScoreEl = document.getElementById('securityScore');

    // Sample password data
    const samplePasswords = [
        {
            id: 1,
            title: 'Facebook',
            username: 'john.doe@example.com',
            password: 'fb@S3cur3Passw0rd!',
            website: 'https://facebook.com',
            createdAt: '2024-03-01T10:30:00.000Z',
            modifiedAt: '2024-04-08T14:25:00.000Z',
            notes: 'Personal Facebook account for connecting with friends and family.',
            history: [
                { password: '********', date: '2024-03-15T09:15:00.000Z' },
                { password: '********', date: '2024-03-01T10:30:00.000Z' }
            ]
        },
        {
            id: 2,
            title: 'Gmail',
            username: 'john.doe@gmail.com',
            password: 'Str0ng!Pa$$w0rd',
            website: 'https://gmail.com',
            createdAt: '2024-02-15T08:45:00.000Z',
            modifiedAt: '2024-04-01T11:20:00.000Z',
            notes: 'Primary email account used for important communications.',
            history: [
                { password: '********', date: '2024-04-01T11:20:00.000Z' },
                { password: '********', date: '2024-02-15T08:45:00.000Z' }
            ]
        },
        {
            id: 3,
            title: 'Twitter',
            username: 'johndoe',
            password: 'weakpass',
            website: 'https://twitter.com',
            createdAt: '2024-01-20T15:10:00.000Z',
            modifiedAt: '2024-01-20T15:10:00.000Z',
            notes: 'Social media account for news and updates.',
            history: [
                { password: '********', date: '2024-01-20T15:10:00.000Z' }
            ]
        },
        {
            id: 4,
            title: 'LinkedIn',
            username: 'john.doe@example.com',
            password: 'L!nk3d&In2023',
            website: 'https://linkedin.com',
            createdAt: '2023-12-05T09:30:00.000Z',
            modifiedAt: '2024-03-10T16:45:00.000Z',
            notes: 'Professional networking account for career opportunities.',
            history: [
                { password: '********', date: '2024-03-10T16:45:00.000Z' },
                { password: '********', date: '2023-12-05T09:30:00.000Z' }
            ]
        }
    ];

    // Load passwords from localStorage or use sample data if none exist
    let passwords = JSON.parse(localStorage.getItem('passwords')) || [];
    
    // Add sample data if no passwords exist
    if (passwords.length === 0) {
        passwords = samplePasswords;
        localStorage.setItem('passwords', JSON.stringify(passwords));
    }
    
    updatePasswordList();
    updateStatistics();

    // Back to Dashboard button
    backToDashboard.addEventListener('click', (e) => {
        e.preventDefault();
        showDashboard();
    });

    // Add Password Modal
    addPasswordBtn.addEventListener('click', () => {
        addPasswordModal.classList.remove('hidden');
    });

    cancelAddPassword.addEventListener('click', () => {
        addPasswordModal.classList.add('hidden');
        addPasswordForm.reset();
    });

    // Import/Export Modal
    importPasswordsBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Import Passwords';
        importExportModal.classList.remove('hidden');
    });

    exportPasswordsBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Export Passwords';
        importExportModal.classList.remove('hidden');
    });

    cancelImportExport.addEventListener('click', () => {
        importExportModal.classList.add('hidden');
        importExportForm.reset();
    });

    // Handle form submissions
    addPasswordForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addPasswordForm);
        const now = new Date();
        const newPassword = {
            id: Date.now(),
            title: formData.get('title'),
            username: formData.get('username'),
            password: formData.get('password'),
            website: formData.get('website'),
            createdAt: now.toISOString(),
            modifiedAt: now.toISOString(),
            notes: '',
            history: [
                { password: '********', date: now.toISOString() }
            ]
        };

        passwords.push(newPassword);
        localStorage.setItem('passwords', JSON.stringify(passwords));
        updatePasswordList();
        updateStatistics();
        addPasswordModal.classList.add('hidden');
        addPasswordForm.reset();
    });

    importExportForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(importExportForm);
        const format = formData.get('format');
        const file = formData.get('file');

        if (modalTitle.textContent === 'Import Passwords') {
            handleImport(file, format);
        } else {
            handleExport(format);
        }
    });

    // Password list functions
    function updatePasswordList() {
        passwordList.innerHTML = '';
        passwords.forEach(password => {
            const passwordEl = createPasswordElement(password);
            passwordList.appendChild(passwordEl);
        });
    }

    function createPasswordElement(password) {
        const div = document.createElement('div');
        div.className = 'border border-gray-200 rounded-lg p-4 bg-white mb-4 shadow-sm';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-1">
                <h3 class="font-bold">${password.title}</h3>
                <div class="flex space-x-2">
                    <button class="eye-icon" onclick="togglePassword('${password.id}')">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                    <button class="copy-icon" onclick="copyPassword('${password.id}')">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                    </button>
                    <a href="single.html?id=${password.id}" class="details-btn px-3 py-1 text-sm border rounded hover:bg-gray-50">
                        Details
                    </a>
                </div>
            </div>
            <p class="text-gray-600 text-sm">${password.username}</p>
            <input type="password" value="${password.password}" class="hidden" id="password-${password.id}">
        `;
        return div;
    }

    // Password detail view functions
    window.showPasswordDetails = function(id) {
        const password = passwords.find(p => p.id == id);
        if (!password) return;
        
        // Populate detail view
        detailTitle.textContent = password.title;
        visitSiteBtn.href = password.website;
        detailUsername.value = password.username;
        detailPassword.value = password.password;
        detailNotes.textContent = password.notes || 'No notes available.';
        
        // Format dates
        const createdDate = new Date(password.createdAt);
        const modifiedDate = new Date(password.modifiedAt);
        detailCreated.textContent = formatDate(createdDate);
        detailModified.textContent = formatDate(modifiedDate);
        
        // Show password history
        passwordHistory.innerHTML = '';
        if (password.history && password.history.length > 0) {
            password.history.forEach(item => {
                const historyItem = document.createElement('div');
                historyItem.className = 'password-history-item flex justify-between';
                historyItem.innerHTML = `
                    <div class="font-mono">${item.password}</div>
                    <div class="text-gray-500">${formatDate(new Date(item.date))}</div>
                `;
                passwordHistory.appendChild(historyItem);
            });
        } else {
            passwordHistory.innerHTML = '<p class="text-gray-500">No password history available.</p>';
        }
        
        // Show detail view
        dashboardView.classList.add('hidden');
        passwordDetailView.classList.remove('hidden');
    };

    // Helper function to format dates
    function formatDate(date) {
        return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
    }

    // Show dashboard function
    function showDashboard() {
        passwordDetailView.classList.add('hidden');
        dashboardView.classList.remove('hidden');
    }

    // Statistics functions
    function updateStatistics() {
        totalPasswordsEl.textContent = passwords.length;
        
        const weakPasswords = passwords.filter(p => isWeakPassword(p.password)).length;
        weakPasswordsEl.textContent = weakPasswords;

        const reusedPasswords = findReusedPasswords().length;
        reusedPasswordsEl.textContent = reusedPasswords;

        const score = calculateSecurityScore();
        securityScoreEl.textContent = score;
    }

    function isWeakPassword(password) {
        return password.length < 8 || 
               !/[A-Z]/.test(password) || 
               !/[a-z]/.test(password) || 
               !/[0-9]/.test(password) || 
               !/[^A-Za-z0-9]/.test(password);
    }

    function findReusedPasswords() {
        const passwordMap = new Map();
        passwords.forEach(p => {
            if (!passwordMap.has(p.password)) {
                passwordMap.set(p.password, []);
            }
            passwordMap.get(p.password).push(p);
        });
        return Array.from(passwordMap.values()).filter(arr => arr.length > 1);
    }

    function calculateSecurityScore() {
        if (passwords.length === 0) return 100;
        
        const weakPasswordPenalty = passwords.filter(p => isWeakPassword(p.password)).length * 10;
        const reusedPasswordPenalty = findReusedPasswords().length * 15;
        const totalPenalty = weakPasswordPenalty + reusedPasswordPenalty;
        
        return Math.max(0, 100 - totalPenalty);
    }

    // Import/Export functions
    function handleImport(file, format) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const data = format === 'json' ? 
                    JSON.parse(e.target.result) : 
                    parseCSV(e.target.result);
                
                passwords = [...passwords, ...data];
                localStorage.setItem('passwords', JSON.stringify(passwords));
                updatePasswordList();
                updateStatistics();
                importExportModal.classList.add('hidden');
                importExportForm.reset();
            } catch (error) {
                alert('Error importing passwords: ' + error.message);
            }
        };
        reader.readAsText(file);
    }

    function handleExport(format) {
        const data = format === 'json' ? 
            JSON.stringify(passwords, null, 2) : 
            convertToCSV(passwords);
        
        const blob = new Blob([data], { type: format === 'json' ? 'application/json' : 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `passwords.${format}`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        importExportModal.classList.add('hidden');
        importExportForm.reset();
    }

    function parseCSV(csv) {
        const lines = csv.split('\n');
        const headers = lines[0].split(',');
        return lines.slice(1).map(line => {
            const values = line.split(',');
            const now = new Date();
            return {
                id: Date.now() + Math.random(),
                title: values[0],
                username: values[1],
                password: values[2],
                website: values[3],
                createdAt: now.toISOString(),
                modifiedAt: now.toISOString(),
                notes: '',
                history: [
                    { password: '********', date: now.toISOString() }
                ]
            };
        });
    }

    function convertToCSV(data) {
        const headers = ['title', 'username', 'password', 'website'];
        const csvRows = [headers.join(',')];
        
        data.forEach(item => {
            const row = headers.map(header => item[header] || '');
            csvRows.push(row.join(','));
        });
        
        return csvRows.join('\n');
    }
});

// Global functions for password actions
function copyPassword(id) {
    const input = document.getElementById(`password-${id}`);
    input.select();
    document.execCommand('copy');
    alert('Password copied to clipboard!');
}

function togglePassword(id) {
    const input = document.getElementById(`password-${id}`);
    if (input.classList.contains('hidden')) {
        input.classList.remove('hidden');
        input.type = 'text';
        setTimeout(() => {
            input.classList.add('hidden');
            input.type = 'password';
        }, 3000); // Hide after 3 seconds
    } else {
        input.type = input.type === 'password' ? 'text' : 'password';
    }
}

function toggleDetailPassword() {
    const input = document.getElementById('detailPassword');
    input.type = input.type === 'password' ? 'text' : 'password';
}

function copyDetail(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    document.execCommand('copy');
    alert('Copied to clipboard!');
}

function deletePassword(id) {
    if (confirm('Are you sure you want to delete this password?')) {
        let passwords = JSON.parse(localStorage.getItem('passwords')) || [];
        passwords = passwords.filter(p => p.id != id);
        localStorage.setItem('passwords', JSON.stringify(passwords));
        
        // Update UI
        const dashboardView = document.getElementById('dashboardView');
        const passwordDetailView = document.getElementById('passwordDetailView');
        
        // Show dashboard if we're in detail view
        if (!passwordDetailView.classList.contains('hidden')) {
            passwordDetailView.classList.add('hidden');
            dashboardView.classList.remove('hidden');
        }
        
        updatePasswordList();
        updateStatistics();
    }
} 