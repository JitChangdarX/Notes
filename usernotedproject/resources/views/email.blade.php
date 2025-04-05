<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Email/Password - xAI</title>
    <link rel="stylesheet" href="{{ asset('asset/css/email.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
 
        </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="image-section">
                <img src="https://source.unsplash.com/600x400/?technology,space" alt="Tech Illustration" class="form-image">
            </div>
            <div class="form-section">
                <h1 class="form-title">Forgot Email or Password?</h1>
                <p class="form-subtitle">Enter your email to reset your credentials.</p>
                <form id="resetForm" class="reset-form">
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="you@example.com" required>
                        <span class="input-icon">✉️</span>
                        <span class="error-message" id="emailError"></span>
                    </div>
                    <button type="submit" class="submit-btn">Send Reset Link</button>
                </form>
                <p class="back-link">
                    <a href="{{ route('login') }}" class="link">Back to Login</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="success-popup" id="successPopup">
        <div class="popup-content">
            <span class="popup-icon">✓</span>
            <p>Reset link sent! Check your email.</p>
            <button class="popup-close" onclick="closePopup()">OK</button>
        </div>
    </div>
    <script src="{{ asset('asset/js/email.js') }}"></script>
</body>
</html>