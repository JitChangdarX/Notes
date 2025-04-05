// function myFunction() {
//     var password = document.getElementById("password");
//     var eyeIcon = document.getElementById("eyeIcon");

//     if (password.type === "password") {
//         password.type = "text"; 
//         eyeIcon.classList.remove("ri-eye-off-line");
//         eyeIcon.classList.add("ri-eye-line"); // Change icon to open eye
//     } else {
//         password.type = "password"; 
//         eyeIcon.classList.remove("ri-eye-line");
//         eyeIcon.classList.add("ri-eye-off-line"); // Change icon to closed eye
//     }
// }


function recaptchaCallback(response) {
    console.log("ReCAPTCHA verified:", response);
    document.getElementById("recaptchaResponse").value = response;
}

// function togglePassword() {
//     const passwordInput = document.getElementById('password');
//     const eyeIcon = document.getElementById('eyeIcon');
    
//     if (passwordInput.type === 'password') {
//         passwordInput.type = 'text';
//         eyeIcon.classList.replace('ri-eye-off-line', 'ri-eye-line');
//     } else {
//         passwordInput.type = 'password';
//         eyeIcon.classList.replace('ri-eye-line', 'ri-eye-off-line');
//     }
// }

// function recaptchaCallback(response) {
//     document.getElementById('recaptchaResponse').value = response;
// }





document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('loginError');
    if (!alert) return;

    // Improved close button handling
    const closeButton = alert.querySelector('.alert-close');
    
    const dismiss = () => {
        alert.style.animation = 'none';
        alert.classList.add('global-alert-exit');
        setTimeout(() => {
            alert.remove();
        }, 400);
    };

    // Auto-dismiss
    let timeoutId = setTimeout(dismiss, 5000);

    // Close button click handler
    closeButton.addEventListener('click', (e) => {
        clearTimeout(timeoutId); // Cancel auto-dismiss
        dismiss();
    });

    // Hover interactions
    alert.addEventListener('mouseenter', () => {
        clearTimeout(timeoutId); // Pause auto-dismiss on hover
        alert.style.transform = 'translateY(-3px)';
        alert.style.boxShadow = '0 12px 40px rgba(0,0,0,0.15)';
    });

    alert.addEventListener('mouseleave', () => {
        timeoutId = setTimeout(dismiss, 5000); // Resume auto-dismiss
        alert.style.transform = 'translateY(0)';
        alert.style.boxShadow = '0 8px 32px rgba(0,0,0,0.1)';
    });
});