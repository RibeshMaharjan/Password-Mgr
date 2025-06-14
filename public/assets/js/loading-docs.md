# Loading Screen Documentation

This document explains how to use the loading screen functionality in the KeyNest application.

## Automatic Loading Screen

The loading screen will automatically appear in the following situations:

1. When a form is submitted
2. When a link is clicked (except for anchor links, external links, and JavaScript links)

## Custom Loading Messages

The loading screen displays context-specific messages based on the action being performed:

### Form Submissions
- Login form: "Logging in..."
- Profile form: "Saving profile..."
- Signup form: "Creating account..."
- Password-related forms: "Processing password..."
- Verification-related forms: "Verifying..."
- Other forms: "Loading..."

### Page Navigation
- Login page: "Loading login page..."
- Signup page: "Loading signup page..."
- Dashboard: "Loading dashboard..."
- Profile page: "Loading profile..."
- Password manager: "Loading password manager..."
- Verification page: "Loading verification page..."
- Other pages: "Loading page..."

## Manual Control

You can manually control the loading screen using the following JavaScript functions:

### Show Loading Screen
```javascript
// Show loading screen with default message
showLoading();

// Show loading screen with custom message
showLoading('Custom loading message...');
```

### Hide Loading Screen
```javascript
// Hide loading screen
hideLoading();
```

### AJAX Requests with Loading Screen
```javascript
// Make a GET request with loading screen
ajaxWithLoading('/api/data')
    .then(response => response.json())
    .then(data => {
        // Process data
    })
    .catch(error => {
        console.error('Error:', error);
    });

// Make a POST request with loading screen and custom message
ajaxWithLoading('/api/save', {
    method: 'POST',
    body: JSON.stringify({ key: 'value' })
}, 'Saving data...')
    .then(response => response.json())
    .then(data => {
        // Process response
    })
    .catch(error => {
        console.error('Error:', error);
    });
```

## Implementation Details

The loading screen is implemented in `loading.js` and consists of:

1. A full-screen overlay with semi-transparent black background
2. A spinning animation
3. A customizable text message

The loading screen is automatically added to the DOM when the page loads and is hidden by default. It becomes visible when triggered by one of the methods described above.