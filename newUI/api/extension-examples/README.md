# Extension API Examples

This directory contains examples of how to use the Password Manager API endpoints from a browser extension.

## OTP Verification API

### Endpoint: `/api/verifyOtp.php`

This endpoint is used to verify the One-Time Password (OTP) sent to the user's email during the two-factor authentication process.

#### Request

- **Method:** POST
- **Headers:**
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Body:**
  ```json
  {
    "otp": "123456"
  }
  ```
  The `otp` field contains the OTP code entered by the user.
- **Credentials:** include (to support cookies for session management)

#### Response

**Success Response:**
```json
{
  "success": true,
  "message": "OTP verified successfully",
  "token": "generated_token_string",
  "email": "user@example.com"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message explaining what went wrong"
}
```

Possible error messages:
- "OTP is required"
- "Invalid OTP"
- "OTP has expired"
- "Server error: [error details]"

### Usage Examples

#### JavaScript Example
See the `verifyOtp-example.js` file for a complete example of how to use this endpoint in a browser extension.

The JavaScript example includes:
1. A reusable function to call the API
2. Error handling
3. Storing the token and username in chrome.storage.local
4. UI feedback through notifications

#### HTML Form Example
See the `verifyOtp-example.html` file for a complete HTML form example that demonstrates the OTP verification flow.

The HTML example includes:
1. A styled form with input validation
2. Loading indicators and notifications
3. Complete JavaScript implementation
4. Error handling and success handling

## Integration Flow

1. User logs in with username/password
2. If 2FA is enabled, the login API returns `{"success": true, "is2FAEnabled": true}`
3. Extension shows OTP input form
4. User enters OTP received via email
5. Extension calls verifyOtp.php with the entered OTP
6. On successful verification, extension stores the token and username
7. Extension proceeds to the authenticated state

## Security Considerations

- Always use HTTPS in production
- Store tokens securely using chrome.storage.local
- Clear tokens on logout
- Handle expired tokens appropriately
