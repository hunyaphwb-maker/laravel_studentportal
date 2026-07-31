<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial, sans-serif;">
    <div style="max-width:600px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border-radius:12px;padding:24px;border:1px solid #e5e7eb;">
            <h1 style="margin:0 0 12px;font-size:20px;color:#111827;">Reset your password</h1>
            <p style="margin:0 0 16px;font-size:14px;line-height:20px;color:#374151;">
                Click the button below to reset your password. If you did not request this, you can ignore this email.
            </p>

            <p style="margin:0 0 18px;">
                <a href="{{ $resetUrl }}" style="display:inline-block;background:#111827;color:#ffffff;text-decoration:none;padding:12px 16px;border-radius:10px;font-size:14px;">
                    Reset Password
                </a>
            </p>

            <p style="margin:0;font-size:12px;line-height:18px;color:#6b7280;">
                If the button does not work, copy and paste this link into your browser:
                <br>
                <a href="{{ $resetUrl }}" style="color:#111827;">{{ $resetUrl }}</a>
            </p>
        </div>
    </div>
</body>
</html>

