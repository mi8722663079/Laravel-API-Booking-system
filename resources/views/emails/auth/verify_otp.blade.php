<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
</head>
<body style="font-family: sans-serif; padding: 20px; color: #333;">
    <h2>Security Verification</h2>
    <p>Your one-time password (OTP) to continue is:</p>
    
    <div style="background-color: #f3f4f6; padding: 15px; display: inline-block; border-radius: 5px; margin: 10px 0;">
        <h3 style="letter-spacing: 5px; font-size: 24px; margin: 0; color: #111;">{{ $otp }}</h3>
    </div>

    <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
        This code is valid for 10 minutes. If you did not request this, please ignore this email.
    </p>
</body>
</html>