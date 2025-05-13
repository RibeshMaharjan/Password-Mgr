// Example of how to use the verifyOtp.php endpoint from the extension

/**
 * Function to verify OTP code
 * @param {string} otp - The OTP code entered by the user
 * @returns {Promise<Object>} - Response from the server
 */
async function verifyOtp(otp) {
  try {
    // Validate input
    if (!otp || otp.trim() === '') {
      throw new Error('OTP is required');
    }

    // Make request to verifyOtp.php endpoint
    const response = await fetch("http://localhost/Password-Mgr/newUi/api/verifyOtp.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify({
        otp: otp
      }),
      credentials: 'include'
    });

    // Check if response is ok
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Parse response
    const result = await response.json();

    // Handle successful response
    if (result.success) {
      // Store both token and username in chrome storage
      chrome.storage.local.set({
        token: result.token,
        username: result.email
      }, () => {
        console.log('Token and username stored successfully');
      });
      
      return {
        success: true,
        message: result.message,
        token: result.token,
        email: result.email
      };
    } else {
      // Handle error response
      return {
        success: false,
        message: result.message
      };
    }
  } catch (error) {
    console.error("OTP verification error:", error);
    return {
      success: false,
      message: "Connection error"
    };
  }
}

/**
 * Example usage in an event listener
 */
document.getElementById('verifyBtn').addEventListener('click', async (e) => {
  e.preventDefault();
  
  const otpInput = document.getElementById('otpInput');
  
  if (otpInput.value.trim() === '') {
    showNotification("Please enter your OTP", "error");
    otpInput.focus();
    return;
  }
  
  // Show loading state
  setLoadingState(true);
  
  try {
    const result = await verifyOtp(otpInput.value);
    
    if (result.success) {
      showNotification(result.message, "success");
      // Redirect or update UI as needed
      checkLogin();
    } else {
      showNotification(result.message, "error");
    }
  } catch (error) {
    console.error("Verification error:", error);
    showNotification("Connection error", "error");
  } finally {
    setLoadingState(false);
  }
});