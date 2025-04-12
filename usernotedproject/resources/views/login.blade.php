<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('asset/1828466.png') }}" type="image/x-icon">
    <script src="{{ asset('asset/js/login.js') }}"></script>
    <title>Login - MyApp</title>
</head>

<body>
    <div class="login-container">
        <!-- Global Messages -->
        @if (session('success'))
            <div class="global-alert global-success" id="successMessage">
                <div class="alert-content">
                    <div class="alert-icon">✅</div>
                    <div class="alert-body">
                        <p class="alert-title">Success</p>
                        <p class="alert-message">{{ session('success') }}</p>
                    </div>
                </div>
                <div class="alert-close">×</div>
                <div class="alert-progress"></div>
            </div>
        @endif
        @if (session('error') || $errors->any())
            <div class="global-alert global-error" id="errorMessage">
                <div class="alert-content">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-body">
                        <p class="alert-title">Error</p>
                        @if (session('error'))
                            <p class="alert-message">{{ session('error') }}</p>
                        @endif
                        @if ($errors->has('login_error'))
                            <p class="alert-message">{{ $errors->first('login_error') }}</p>
                        @endif
                        @if ($errors->has('email'))
                            <p class="alert-message">{{ $errors->first('email') }}</p>
                        @endif
                        @if ($errors->has('password'))
                            <p class="alert-message">{{ $errors->first('password') }}</p>
                        @endif
                        @if ($errors->has('g-recaptcha-response'))
                            <p class="alert-message">{{ $errors->first('g-recaptcha-response') }}</p>
                        @endif
                    </div>
                </div>
                <div class="alert-close">×</div>
                <div class="alert-progress"></div>
            </div>
        @endif
    </div>

    <div class="login">
        <img src="{{ asset('asset/login-bg.png') }}" alt="image" class="login__bg">

        @if (Auth::check())
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.jpg') }}"
                alt="Profile Picture">
        @endif

        <div class="login__container">
            <form action="{{ route('loginaction') }}" method="post" class="login__form">
                @csrf
                <h1 class="login__title">Login</h1>

                <div class="login__inputs">
                    <!-- Email Input -->
                    <div class="login__box @error('email') shake @enderror">
                        <input type="email" placeholder="Email ID" id="email" name="email" class="login__input"
                            value="{{ old('email') }}" autocomplete="off">
                        <i class="ri-mail-fill"></i>
                        @error('email')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="login__box @error('password') shake @enderror">
                        <input type="password" placeholder="Password" name="password" class="login__input" id="password"
                            autocomplete="off">
                        <i id="eyeIcon" class="ri-eye-off-line" style="cursor: pointer"></i>
                        @error('password')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="recaptcha-wrapper">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}"
                            data-callback="recaptchaCallback">
                        </div>
                        <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                        @error('g-recaptcha-response')
                            <div class="recaptcha-error">{{ $message }}</div>
                        @endif
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="login__check">
                    <div class="login__check-box">
                        <input type="checkbox" class="login__check-input" id="user-check" name="remember">
                        <label for="user-check" class="login__check-label">Remember me</label>
                    </div>
                    <a href="{{ route('otp.form') }}" class="login__forgot">Forgot Password?</a>
                </div>

                <button type="submit" class="login__button">Login</button>

                <div class="login__register">
                    Don't have an account? <a href="{{ route('signup') }}">Register</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        // Debug Session Data
        console.log("Session Success: {{ session('success', 'none') }}");

        // Toggle Password Visibility
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("ri-eye-off-line");
                eyeIcon.classList.add("ri-eye-line");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("ri-eye-line");
                eyeIcon.classList.add("ri-eye-off-line");
            }
        }

        // Reset reCAPTCHA
        function resetRecaptcha() {
            grecaptcha.reset();
        }

        // Log Form Data
        document.querySelector('.login__form').addEventListener('submit', function(e) {
            var formData = new FormData(this);
            console.log("Form Data Before Submission:");
            for (var pair of formData.entries()) {
                console.log(pair[0] + ": " + pair[1]);
            }
        });

        // Prevent Back Navigation
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Password Visibility with Timeout
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        let timeoutId;

        function updateEyeState() {
            if (passwordInput.value.length > 0) {
                eyeIcon.classList.remove('ri-eye-off-line');
                eyeIcon.classList.add('ri-eye-line');
                passwordInput.type = 'text';
                resetTimeout();
            } else {
                eyeIcon.classList.remove('ri-eye-line');
                eyeIcon.classList.add('ri-eye-off-line');
                passwordInput.type = 'password';
            }
        }

        function resetTimeout() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('ri-eye-line');
                eyeIcon.classList.add('ri-eye-off-line');
            }, 1500);
        }

        passwordInput.addEventListener('input', updateEyeState);
        passwordInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('ri-eye-line');
                eyeIcon.classList.add('ri-eye-off-line');
            }
        });

        // Handle Alerts
        document.querySelectorAll('.global-alert').forEach(alert => {
            const closeButton = alert.querySelector('.alert-close');

            const dismiss = () => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 400);
            };

            // Close button click handler
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    dismiss();
                });
            }

            // Auto-dismiss
            let timeoutId = setTimeout(dismiss, 5000);

            // Hover interactions
            alert.addEventListener('mouseenter', () => {
                clearTimeout(timeoutId);
                alert.style.transform = 'translateY(-3px)';
                alert.style.boxShadow = '0 12px 40px rgba(0,0,0,0.15)';
            });

            alert.addEventListener('mouseleave', () => {
                timeoutId = setTimeout(dismiss, 5000);
                alert.style.transform = 'translateY(0)';
                alert.style.boxShadow = '0 8px 32px rgba(0,0,0,0.1)';
            });
        });
    </script>
</body>

</html>