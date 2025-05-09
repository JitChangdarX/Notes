<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <link rel="icon" href="{{ asset('asset/1828466.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}">
    <title>Login - MyApp</title>
</head>

<body>
    @php
        $prefilledEmail = session('recent_signup_email');
        session()->forget('recent_signup_email');
    @endphp
    <div class="login-container">
        <nav class="nav-bar">
            <a href="{{ route('signup') }}">Home</a>
            <a href="{{ route('logins') }}">Login</a>
            <a href="{{ route('contact') }}">Contact</a>
        </nav>
        @if (session('success'))
            <div class="global-alert global-success" id="successMessage"
                style="display: block; opacity: 1; transform: translateX(-50%);">
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
        @if (session('error'))
            <div class="global-alert global-error" id="errorMessage"
                style="display: block; opacity: 1; transform: translateX(-50%);">
                <div class="alert-content">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-body">
                        <p class="alert-title">Error</p>
                        <p class="alert-message">{{ session('error') }}</p>
                    </div>
                </div>
                <div class="alert-close">×</div>
                <div class="alert-progress"></div>
            </div>
        @endif
    </div>

    <div class="login">
        <img src="{{ asset('asset/login-bg.png') }}" alt="Background" class="login__bg" loading="lazy">
        <div class="login__container">
            <form action="{{ route('loginaction') }}" method="post" class="login__form">
                @csrf
                <h1 class="login__title">Login</h1>
                <div class="login__inputs">
                    <div class="login__box @error('email') shake @enderror">
                        <input type="email" placeholder="Email ID" id="email" name="email" class="login__input"
                            value="{{ old('email', $prefilledEmail) }}" autocomplete="off">
                        <i class="ri-mail-fill"></i>
                        @error('email')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="login__box @error('password') shake @enderror">
                        <input type="password" placeholder="Password" name="password" class="login__input"
                            id="password" autocomplete="off">
                        <i id="eyeIcon" class="ri-eye-off-line" style="cursor: pointer"></i>
                        @error('password')
                            <div class="error-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="recaptcha-wrapper">
                        <div class="cf-turnstile" data-sitekey="{{ config('turnstile.turnstile_site_key') }}"></div>
                        <input type="hidden" name="cf-turnstile-response" id="cfTurnstileResponse">
                        @error('cf-turnstile-response')
                            <div class="recaptcha-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
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
            <div id="loader" class="loader-overlay">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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

        // Alert Handling (Manual Close Only)
        document.querySelectorAll('.global-alert').forEach(alert => {
            const closeButton = alert.querySelector('.alert-close');
            const dismiss = () => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(-50%) translateY(-10px)';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 400);
            };

            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    dismiss();
                });
            }
        });

        // Prevent Back Navigation
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Show Loader on Form Submission
        $(document).ready(function() {
            $('.login__form').on('submit', function() {
                $('#loader').css('display', 'flex');
            });
        });
    </script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</body>

</html>
