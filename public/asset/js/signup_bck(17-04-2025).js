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
        // Check validation before showing loader
        if (!validateAndSubmitForm(e)) {
            loader.style.display = 'none';
            button.disabled = false;
            return;
        }

        // Show loader only if validation passed
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


          // Toggle password visibility
          function togglePassword() {
            const password = document.getElementById('password');
            const confirm = document.getElementById('confirmpassword');
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = confirm.type = type;
        }
    
        // Password strength
        function checkStrength() {
            const password = document.getElementById('password').value;
            const strengthResult = document.getElementById('strengthResult');
            let strength = '';
            let color = '';
    
            if (password.length === 0) {
                strength = '';
            } else if (password.length < 6) {
                strength = 'Weak';
                color = 'text-danger';
            } else if (password.length < 10) {
                strength = 'Medium';
                color = 'text-warning';
            } else {
                strength = 'Strong';
                color = 'text-success';
            }
    
            strengthResult.textContent = strength ? `Strength: ${strength}` : '';
            strengthResult.className = `mt-1 text-sm ${color}`;
        }
    
       
        function validateAndSubmitForm(event) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirmpassword').value;
        
            if (password !== confirm || password.length < 6) {
                event.preventDefault();
                alert("Passwords must match and be at least 6 characters.");
                return false;
            }
        
            return true;
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
        });




        const dropArea = document.getElementById('drop-area');
        const preview = document.getElementById('preview');
      
        // Handle file selection from input
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
      
        // Handle drag-and-drop
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
      
        // Add image to preview with animation and remove button
        function addPreview(src, name) {
          const div = document.createElement('div');
          div.className = 'preview-item w-full max-w-xs'; // Fixed width for better alignment
          
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


        function validateEmail() {
            const emailInput = document.getElementById("email");
            const emailError = document.getElementById("emailError");
            const signupBtn = document.getElementById("signup-btn");
            const email = emailInput.value.trim(); // Remove leading/trailing whitespace
        
            // Clear previous error message
            emailError.innerHTML = "";
        
            // Check if email is empty
            if (!email) {
                emailError.innerHTML = "Email is required";
                signupBtn.disabled = true;
                return; // Exit early to avoid unnecessary regex check
            }
        
            // Improved email regex (more precise and standard-compliant)
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/;
        
            // Test email format
            if (emailRegex.test(email)) {
                emailError.innerHTML = ""; // Clear error message
                signupBtn.disabled = false;
            } else {
                emailError.innerHTML = "Please enter a valid email address";
                signupBtn.disabled = true;
            }
        }
        

        


        // Enhanced Drop Zone Interactions
const dropArea = document.getElementById('drop-area');

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.classList.add('dragover');
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.classList.remove('dragover');
    });
});

// Enhanced Button Loading Animation
function validateAndSubmitForm(event) {
    event.preventDefault();
    const btn = document.getElementById('signup-btn');
    btn.classList.add('btn-loading');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Creating Account...';
    
    // Simulate async submission
    setTimeout(() => {
        btn.classList.remove('btn-loading');
        btn.innerHTML = 'Sign Up';
        event.target.submit();
    }, 2000);
    return false;
}

// Animated Password Strength
function checkStrength() {
    const password = document.getElementById('password').value;
    const strengthResult = document.getElementById('strengthResult');
    const strength = calculatePasswordStrength(password);
    
    strengthResult.innerHTML = `
        <div class="strength-bar" style="width: ${strength.width}; background: ${strength.color}"></div>
    `;
}

function calculatePasswordStrength(password) {
    const strength = zxcvbn(password);
    return {
        width: `${(strength.score * 25)}%`,
        color: ['#ff4444', '#ffbb33', '#00C851', '#00C851', '#00C851'][strength.score]
    };
}

// Parallax Effect for Card
document.addEventListener('mousemove', (e) => {
    const card = document.querySelector('.signup-card');
    const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
    const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
    card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
});

// Initialize zxcvbn for password strength
// Add this script tag: <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>