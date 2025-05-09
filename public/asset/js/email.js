document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Reset error message
    emailError.style.display = 'none';
    emailError.textContent = '';

    // Validation with animation
    if (!email.value) {
        emailError.textContent = 'Email is required.';
        emailError.style.display = 'block';
        email.classList.add('shake');
        setTimeout(() => email.classList.remove('shake'), 500);
        return;
    } else if (!emailRegex.test(email.value)) {
        emailError.textContent = 'Please enter a valid email address.';
        emailError.style.display = 'block';
        email.classList.add('shake');
        setTimeout(() => email.classList.remove('shake'), 500);
        return;
    }

    // Simulate sending reset link with button animation
    const btn = document.querySelector('.submit-btn');
    btn.textContent = 'Sending...';
    btn.classList.add('pulse');
    
    setTimeout(() => {
        btn.textContent = 'Send Reset Link';
        btn.classList.remove('pulse');
        const popup = document.getElementById('successPopup');
        popup.classList.add('active');
        document.getElementById('resetForm').reset();
    }, 1000); // Simulated delay
});

function closePopup() {
    const popup = document.getElementById('successPopup');
    popup.style.animation = 'popupFadeOut 0.4s ease forwards';
    setTimeout(() => {
        popup.classList.remove('active');
        popup.style.animation = '';
    }, 400);
}

// Add dynamic style for button pulse
const style = document.createElement('style');
style.textContent = `
    .pulse {
        animation: pulseAnimation 0.8s infinite;
    }
    @keyframes pulseAnimation {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .shake {
        animation: shake 0.5s ease;
    }
`;
document.head.appendChild(style);


