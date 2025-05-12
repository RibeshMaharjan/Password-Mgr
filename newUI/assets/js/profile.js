document.addEventListener('DOMContentLoaded', () => {
    // Create a profile tab state
    const profileTabButtons = document.querySelector('#user-profile-tab').querySelector('[data-tab="profile"]');
    const securityTabButtons = document.querySelector('#user-profile-tab').querySelector('[data-tab="security"]');
    const profileTabContent = document.querySelector('#profile-tab-content');
    const securityTabContent = document.querySelector('#security-tab-content');

    let activeTab = profileTabButtons;
    const messageContainer = document.querySelector('.message-container') ?? '';
    profileTabButtons.addEventListener('click', switchToProfile);
    securityTabButtons.addEventListener('click', switchToSecurity);

    if(messageContainer && (messageContainer.textContent.toLowerCase().includes("password") || messageContainer.textContent.includes("2FA"))){
        switchToSecurity();
    }

    function switchToProfile() {
        profileTabButtons.classList.add('active', 'bg-white', 'shadow');
        profileTabButtons.classList.remove('bg-transparent');
        securityTabButtons.classList.remove('active', 'bg-white', 'shadow');
        securityTabButtons.classList.add('bg-transparent');
        securityTabContent.classList.add('hidden');
        profileTabContent.classList.remove('hidden');
        activeTab = profileTabButtons;
    }

    function switchToSecurity() {
        securityTabButtons.classList.add('active', 'bg-white', 'shadow');
        securityTabButtons.classList.remove('bg-transparent');
        profileTabButtons.classList.remove('active', 'bg-white', 'shadow');
        profileTabButtons.classList.add('bg-transparent');
        profileTabContent.classList.add('hidden');
        securityTabContent.classList.remove('hidden');
        activeTab = securityTabButtons;
    }

    // Profile form logic
    const profileForm = document.getElementById('profileForm');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const nameInput = profileForm.elements['fullname'];
    const emailInput = profileForm.elements['email'];
    const usernameInput = profileForm.elements['username'];

    let editing = false;

    // Edit/Save Profile toggle with separate Cancel and Save buttons
    editProfileBtn.addEventListener('click', () => {
        if (!editing) {
            // Enable fields
            nameInput.disabled = false;
            emailInput.disabled = false;
            usernameInput.disabled = false;

            // Replace Edit button with Cancel and Save buttons
            const buttonContainer = editProfileBtn.parentElement;
            editProfileBtn.classList.add('hidden');

            document.getElementById('cancelEditBtn').addEventListener('click', cancelEditing);

            document.getElementById('cancelEditBtn').classList.remove('hidden');
            document.getElementById('saveChangesBtn').classList.remove('hidden');

            editing = true;
        }
    });

    function cancelEditing() {
        // Disable fields
        nameInput.disabled = true;
        emailInput.disabled = true;
        usernameInput.disabled = true;

        // Hide Cancel and Save buttons, show Edit button
        document.getElementById('cancelEditBtn').classList.add('hidden');
        document.getElementById('saveChangesBtn').classList.add('hidden');
        editProfileBtn.classList.remove('hidden');

        editing = false;
    }
});