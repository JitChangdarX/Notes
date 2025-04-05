function show()
{
var password = document.querySelector("#password");
var password2 = document.querySelector("#passwords");
if (password.type === "password") {
    password.type = "text";
} else {
    password.type = "password";
}

if (password2.type === "password") {
    password2.type = "text";
} else {
    password2.type = "password";
}
}


 // Logo click effect
 window.onload = function() {
    const logo = document.getElementById("logo");
    const content = document.querySelector(".card-body");

    logo.addEventListener("click", () => {
        if (logo.classList.contains("focused")) {
            logo.classList.remove("focused");
            content.classList.remove("blurred");
        } else {
            logo.classList.add("focused");
            content.classList.add("blurred");
        }
    });
};

// Form submission loader
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const loader = document.getElementById('loader');
    const button = document.getElementById('myButton');

    form.addEventListener('submit', (e) => {
        loader.style.display = 'flex';
        button.disabled = true;
    });
});

// Show password toggle
function show() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmpassword");
    const showPassword = document.getElementById("showPassword");

    if (showPassword.checked) {
        password.type = "text";
        confirmPassword.type = "text";
    } else {
        password.type = "password";
        confirmPassword.type = "password";
    }
}


    window.onload = function() {
        const consent = document.querySelector('.cookie-consent');
        consent.style.display = 'block'; // Ensure it’s visible initially
        // Animation is handled by CSS, but JS can confirm visibility
    };

    function acceptCookies() {
        const consent = document.querySelector('.cookie-consent');
        consent.style.opacity = '0';
        consent.style.transform = 'scale(0.8)';
        setTimeout(() => consent.style.display = 'none', 500);
        console.log('Cookies accepted');
    }

    function declineCookies() {
        const consent = document.querySelector('.cookie-consent');
        consent.style.opacity = '0';
        consent.style.transform = 'scale(0.8)';
        setTimeout(() => consent.style.display = 'none', 500);
        console.log('Cookies declined');
    }
