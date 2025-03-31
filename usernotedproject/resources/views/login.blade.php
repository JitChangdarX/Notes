<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Login - MyApp</title>

</head>

<body>
    <div class="login">
        <img src="{{ asset('asset/login-bg.png') }}" alt="image" class="login__bg">

        @if (Auth::check())
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.jpg') }}"
                alt="Profile Picture">
        @endif






        <form action="{{ route('loginaction') }}" method="post" class="login__form">
            @csrf
        
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
        
            <h1 class="login__title">Login</h1>
        
            <div class="login__inputs">
                <!-- Email Input -->
                <div class="login__box @error('email') shake @enderror">
                    <input type="email" 
                           placeholder="Email ID" 
                           id="email" 
                           name="email" 
                           class="login__input"
                           value="{{ old('email') }}"
                           autocomplete="off">
                    <i class="ri-mail-fill"></i>
                    @error('email')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- Password Input -->
                <div class="login__box @error('password') shake @enderror">
                    <input type="password" 
                           placeholder="Password" 
                           name="password" 
                           class="login__input" 
                           id="password"
                           autocomplete="off">
                    <i id="eyeIcon" class="ri-eye-off-line" onclick="togglePassword()" style="cursor: pointer"></i>
                    @error('password')
                        <div class="error-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <!-- reCAPTCHA -->
                <div class="recaptcha-wrapper">
                    <div class="g-recaptcha" 
                         data-sitekey="{{ config('services.recaptcha.sitekey') }}"
                         data-callback="recaptchaCallback">
                    </div>
                    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                    @error('g-recaptcha-response')
                        <div class="recaptcha-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        
            <!-- Remember Me Checkbox - No shake class here -->
            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" 
                           class="login__check-input" 
                           id="user-check"
                           name="remember">
                    <label for="user-check" class="login__check-label" >Remember me</label>
                </div>
                <a href="{{ route('forget_email') }}" class="login__forgot">Forgot Password?</a>
            </div>
        
            <button type="submit" class="login__button">Login</button>
        
            <div class="login__register">
                Don't have an account? <a href="{{ route('signup') }}">Register</a>
            </div>
        </form>


    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
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

        function resetRecaptcha() {
            grecaptcha.reset();
        }

        document.querySelector('.login__form').addEventListener('submit', function(e) {
            var formData = new FormData(this);
            console.log("Form Data Before Submission:");
            for (var pair of formData.entries()) {
                console.log(pair[0] + ": " + pair[1]);
            }
        });
    </script>
    {{-- -> <- handle for secure page i was commentout this part --}}

    {{-- final version --}}
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>

    <script>
        function recaptchaCallback(response) {
            console.log("ReCAPTCHA verified:", response);
            document.getElementById("recaptchaResponse").value = response;
        }
    </script>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('ri-eye-off-line', 'ri-eye-line');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('ri-eye-line', 'ri-eye-off-line');
        }
    }

    function recaptchaCallback(response) {
        document.getElementById('recaptchaResponse').value = response;
    }
</script>
</body>

</html>
