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

        <form action="{{ route('loginaction') }}" method="post" class="login__form">
            @csrf
            <h1 class="login__title">Login</h1>

            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" placeholder="Email ID" name="email" required class="login__input"
                        autocomplete="off">
                    <i class="ri-mail-fill"></i>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login__box">
                    <input type="password" placeholder="Password" name="password" required class="login__input"
                        id="password" autocomplete="off">
                    <i id="eyeIcon" class="ri-eye-off-line" onclick="togglePassword()" style="cursor: pointer"></i>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"
                        data-callback="recaptchaCallback"></div>


                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                    @error('g-recaptcha-response')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Remember me</label>
                </div>
                <a href="{{ route('forget_email') }}" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button" id="submitBtn" disabled>Login</button>

            <div class="login__register">
                Don't have an account? <a href="{{ route('signup') }}">Register</a>
            </div>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        function recaptchaCallback(response) {
            document.getElementById("g-recaptcha-response").value = response;
            document.getElementById("submitBtn").disabled = false;
        }

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

        document.querySelector('.login__form').addEventListener('submit', function() {
            if (!document.getElementById("g-recaptcha-response").value) {
                alert("Please verify reCAPTCHA before submitting.");
                resetRecaptcha();
                return false;
            }
        });
    </script>


</body>

</html>
