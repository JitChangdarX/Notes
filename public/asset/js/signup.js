window.addEventListener('scroll', () => {
    const nav = document.querySelector('.nav-bar');
    if (window.scrollY > 50) nav.classList.add('active');
    else nav.classList.remove('active');
});

// Show cookie consent with animation
window.addEventListener('load', () => {
    const cookieConsent = document.querySelector('.cookie-consent');
    cookieConsent.classList.add('active');
});

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
    const message = document.getElementById('dynamicMessage');

    form.addEventListener('submit', (e) => {
        const isValid = validateAndSubmitForm(e, message);
        if (!isValid) {
            loader.style.display = 'none';
            button.disabled = false;
            return;
        }
        loader.style.display = 'flex';
        button.disabled = true;
        setTimeout(() => {
            loader.style.display = 'none';
            button.disabled = false;
            showMessage('Registration successful!', 'success', message);
            triggerConfetti();
        }, 2000);
    });
});

// Toggle password visibility
function togglePassword() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmpassword');
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = confirmPassword.type = type;
}

// Password strength check
function checkStrength() {
    const password = document.getElementById('password').value;
    const strengthResult = document.getElementById('strengthResult');
    let strength = '';
    let color = '';

    if (password.length === 0) {
        strength = '';
        document.getElementById('confirmpassword').disabled = true;
    } else {
        document.getElementById('confirmpassword').disabled = false;
        if (password.length < 6) {
            strength = 'Weak (minimum 6 characters)';
            color = 'text-danger';
        } else if (password.length < 10 || !/(?=.*[A-Z])(?=.*[!@#$%^&*])/.test(password)) {
            strength = 'Medium (add uppercase or special character)';
            color = 'text-warning';
        } else {
            strength = 'Strong';
            color = 'text-success';
        }
    }
    strengthResult.textContent = strength;
    strengthResult.className = `mt-1 text-sm ${color}`;
}

// Password confirmation check
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmpassword').value;
    const matchResult = document.getElementById('matchResult');

    if (confirmPassword && password !== confirmPassword) {
        matchResult.textContent = 'Passwords do not match';
        matchResult.className = 'mt-1 text-sm text-danger';
    } else {
        matchResult.textContent = password === confirmPassword && confirmPassword ? 'Passwords match' : '';
        matchResult.className = password === confirmPassword && confirmPassword ? 'mt-1 text-sm text-success' : 'mt-1 text-sm';
    }
}

// Enable confirm password on password input
document.getElementById('password').addEventListener('input', () => {
    checkStrength();
    const confirmPassword = document.getElementById('confirmpassword');
    if (document.getElementById('password').value) {
        confirmPassword.disabled = false;
    } else {
        confirmPassword.disabled = true;
        confirmPassword.value = '';
        document.getElementById('matchResult').textContent = '';
    }
});

// Validate confirm password on input
document.getElementById('confirmpassword').addEventListener('input', checkPasswordMatch);

// Dynamic message display
function showMessage(messageText, type = 'error', element) {
    element.textContent = messageText;
    element.className = 'dynamicMessage';
    if (type === 'success') element.classList.add('success');
    else if (type === 'warning') element.classList.add('warning');
    else element.classList.add('show');
    setTimeout(() => {
        element.classList.remove('show', 'success', 'warning');
        element.textContent = '';
    }, 3000);
}

// Form validation and submission
function validateAndSubmitForm(event, message) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmpassword').value;
    const email = document.getElementById('email').value;

    if (!email) {
        showMessage('Email is required.', 'error', message);
        return false;
    }
    if (!validateEmail()) {
        showMessage('Please enter a valid email address.', 'error', message);
        return false;
    }
    if (password !== confirmPassword) {
        showMessage('Passwords do not match.', 'error', message);
        return false;
    }
    if (password.length < 6) {
        showMessage('Password must be at least 6 characters.', 'error', message);
        return false;
    }
    return true;
}

// Email validation
function validateEmail() {
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    const signupBtn = document.getElementById("myButton");
    const email = emailInput.value.trim();

    emailError.innerHTML = "";
    if (!email) {
        emailError.innerHTML = "Email is required";
        signupBtn.disabled = true;
        return false;
    }
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/;
    if (emailRegex.test(email)) {
        emailError.innerHTML = "";
        signupBtn.disabled = false;
        return true;
    } else {
        emailError.innerHTML = "Please enter a valid email address";
        signupBtn.disabled = true;
        return false;
    }
}

// Confetti animation
function triggerConfetti() {
    const canvas = document.getElementById('confettiCanvas');
    const ctx = canvas.getContext('2d');
    canvas.style.display = 'block';
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const confetti = Array.from({ length: 100 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * -canvas.height,
        size: Math.random() * 10 + 5,
        speed: Math.random() * 5 + 2,
        color: `hsl(${Math.random() * 360}, 100%, 50%)`
    }));

    function animateConfetti() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        confetti.forEach(c => {
            c.y += c.speed;
            if (c.y > canvas.height) c.y = -c.size;
            ctx.fillStyle = c.color;
            ctx.beginPath();
            ctx.arc(c.x, c.y, c.size / 2, 0, Math.PI * 2);
            ctx.fill();
        });

        if (confetti.some(c => c.y < canvas.height)) {
            requestAnimationFrame(animateConfetti);
        } else {
            canvas.style.display = 'none';
        }
    }

    animateConfetti();
}

// Particle Background
const particleCanvas = document.getElementById('particleCanvas');
const pCtx = particleCanvas.getContext('2d');
particleCanvas.width = window.innerWidth;
particleCanvas.height = window.innerHeight;

const particles = Array.from({ length: 50 }, () => ({
    x: Math.random() * particleCanvas.width,
    y: Math.random() * particleCanvas.height,
    radius: Math.random() * 3 + 1,
    dx: Math.random() * 2 - 1,
    dy: Math.random() * 2 - 1,
    color: `hsl(${Math.random() * 360}, 70%, 60%)`
}));

let mouse = { x: null, y: null };
window.addEventListener('mousemove', e => {
    mouse.x = e.x;
    mouse.y = e.y;
});

function animateParticles() {
    pCtx.clearRect(0, 0, particleCanvas.width, particleCanvas.height);
    particles.forEach(p => {
        p.x += p.dx;
        p.y += p.dy;

        if (p.x < 0 || p.x > particleCanvas.width) p.dx *= -1;
        if (p.y < 0 || p.y > particleCanvas.height) p.dy *= -1;

        if (mouse.x && mouse.y) {
            const dx = mouse.x - p.x;
            const dy = mouse.y - p.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            if (distance < 100) {
                pCtx.beginPath();
                pCtx.strokeStyle = p.color;
                pCtx.lineWidth = 0.5;
                pCtx.moveTo(p.x, p.y);
                pCtx.lineTo(mouse.x, mouse.y);
                pCtx.stroke();
            }
        }

        pCtx.beginPath();
        pCtx.fillStyle = p.color;
        pCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
        pCtx.fill();
    });

    requestAnimationFrame(animateParticles);
}

animateParticles();

// Resize canvas on window resize
window.addEventListener('resize', () => {
    particleCanvas.width = window.innerWidth;
    particleCanvas.height = window.innerHeight;
    if (document.getElementById('confettiCanvas').style.display === 'block') {
        document.getElementById('confettiCanvas').width = window.innerWidth;
        document.getElementById('confettiCanvas').height = window.innerHeight;
    }
});

// Drag and drop handling
const dropArea = document.getElementById('drop-area');
const preview = document.getElementById('preview');

function handleFiles(files) {
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                addPreview(e.target.result, file.name);
            };
            reader.readAsDataURL(file);
        }
    });
}

dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
});

dropArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
    handleFiles(e.dataTransfer.files);
});

function addPreview(src, name) {
    const div = document.createElement('div');
    div.className = 'preview-item w-full max-w-xs';
    const img = document.createElement('img');
    img.src = src;
    img.alt = name;
    const removeBtn = document.createElement('button');
    removeBtn.innerHTML = '×';
    removeBtn.className = 'remove-btn';
    removeBtn.onclick = (e) => {
        e.preventDefault();
        div.remove();
    };
    const nameP = document.createElement('p');
    nameP.textContent = name;
    div.appendChild(img);
    div.appendChild(removeBtn);
    div.appendChild(nameP);
    preview.appendChild(div);
}



