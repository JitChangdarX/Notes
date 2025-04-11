<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your One-Time Password (OTP)</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .header img {
            max-height: 60px;
            width: auto;
        }

        .header h2 {
            color: #ffffff;
            font-size: 24px;
            margin: 10px 0 0;
            font-weight: 500;
        }

        .content {
            padding: 20px 30px;
        }

        .otp-box {
            background-color: #f8f9fa;
            font-size: 28px;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            letter-spacing: 5px;
            border-radius: 6px;
            margin: 20px 0;
            border: 1px solid #e0e0e0;
            color: #c7ccd1;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            margin: 20px 0;
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Animation */
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            /* Subtle lift effect */
        }

        .terms {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
            line-height: 1.8;
        }

        .terms a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .terms a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 0;
            }

            .otp-box {
                font-size: 24px;
                letter-spacing: 3px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://yourdomain.com/logo.png" alt="YourApp Logo">
            <h2>Verification code</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear User,</p>
            <p>Your One-Time Password (OTP) is:</p>
            <div class="otp-box">{{ $otp }}</div>
            <p>(This code will expire 10 minutes after it was sent.)</p>
            <p>If you didn’t request this OTP, please ignore this email or contact our support team.</p>
            <a href="https://yourdomain.com/support" class="btn">Contact Support</a>

            <!-- Terms and Conditions -->
            <div class="terms">
                By using this OTP, you agree to our
                <a href="https://yourdomain.com/terms">Terms and Conditions</a>
                and
                <a href="https://yourdomain.com/privacy">Privacy Policy</a>.
                Please review these documents to understand your rights and responsibilities.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} YourApp. All rights reserved.<br>
            <a href="https://yourdomain.com">Visit our website</a> |
            <a href="https://yourdomain.com/privacy">Privacy Policy</a> |
            <a href="https://yourdomain.com/terms">Terms of Service</a>
        </div>
    </div>
</body>

</html>
