// Loading Screen Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Create loading overlay element
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loading-overlay';
    loadingOverlay.classList.add('fixed', 'inset-0', 'bg-black', 'bg-opacity-50', 'z-50', 'flex', 'items-center', 'justify-center', 'hidden');

    // Create loading container for spinner and text
    const loadingContainer = document.createElement('div');
    loadingContainer.classList.add('flex', 'flex-col', 'items-center', 'justify-center', 'bg-white', 'bg-opacity-10', 'p-8', 'rounded-lg');

    // Create spinner element
    const spinner = document.createElement('div');
    spinner.classList.add('animate-spin', 'rounded-full', 'h-16', 'w-16', 'border-t-4', 'border-b-4', 'border-white');

    // Create loading text
    const loadingText = document.createElement('div');
    loadingText.id = 'loading-text';
    loadingText.classList.add('text-white', 'font-bold', 'mt-4');
    loadingText.textContent = 'Loading...';

    // Append spinner and text to container
    loadingContainer.appendChild(spinner);
    loadingContainer.appendChild(loadingText);

    // Append container to overlay
    loadingOverlay.appendChild(loadingContainer);

    // Append overlay to body
    document.body.appendChild(loadingOverlay);

    // Function to show loading screen with custom message
    window.showLoading = function(message = 'Loading...') {
        document.getElementById('loading-text').textContent = message;
        loadingOverlay.classList.remove('hidden');
    };

    // Function to hide loading screen
    window.hideLoading = function() {
        loadingOverlay.classList.add('hidden');
    };

    // Helper function for AJAX requests with loading screen
    window.ajaxWithLoading = function(url, options = {}, loadingMessage = 'Loading...') {
        showLoading(loadingMessage);

        // Set default options
        options = Object.assign({
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        }, options);

        return fetch(url, options)
            .then(response => {
                hideLoading();
                return response;
            })
            .catch(error => {
                hideLoading();
                throw error;
            });
    };

    // Add event listeners to all forms with custom messages based on form ID or action
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Custom messages based on form ID or action
            if (form.id === 'loginForm') {
                showLoading('Logging in...');
            } else if (form.id === 'profileForm') {
                showLoading('Saving profile...');
            } else if (form.id === 'signupForm') {
                showLoading('Creating account...');
            } else if (form.id === 'passwordForm' || form.action.includes('password')) {
                showLoading('Processing password...');
            } else if (form.action.includes('verify')) {
                showLoading('Verifying...');
            } else {
                showLoading();
            }
        });
    });

    // Add event listeners to links that navigate to new pages with custom messages
    const links = document.querySelectorAll('a:not([href^="#"]):not([target="_blank"])');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't show loading for links that prevent default
            if (this.getAttribute('href') && 
                !this.getAttribute('href').startsWith('javascript:') &&
                !e.defaultPrevented) {

                const href = this.getAttribute('href').toLowerCase();

                // Custom messages based on link destination
                if (href.includes('login')) {
                    showLoading('Loading login page...');
                } else if (href.includes('signup')) {
                    showLoading('Loading signup page...');
                } else if (href.includes('dashboard')) {
                    showLoading('Loading dashboard...');
                } else if (href.includes('profile')) {
                    showLoading('Loading profile...');
                } else if (href.includes('password')) {
                    showLoading('Loading password manager...');
                } else if (href.includes('verify')) {
                    showLoading('Loading verification page...');
                } else {
                    showLoading('Loading page...');
                }
            }
        });
    });
});
