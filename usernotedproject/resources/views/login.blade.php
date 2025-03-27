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
                    <input type="email" placeholder="Email ID" id="email" name="email" class="login__input"
                        autocomplete="off">
                    <i class="ri-mail-fill"></i>
                    @error('email')
                        <div class="success-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login__box">
                    <input type="password" placeholder="Password" name="password" class="login__input" id="password"
                        autocomplete="off">
                    <i id="eyeIcon" class="ri-eye-off-line" onclick="togglePassword()" style="cursor: pointer"></i>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="recaptcha-wrapper bg-light rounded-3 p-3 mb-2">
                        <div class="d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"
                                data-callback="recaptchaCallback" data-theme="light" data-size="normal">
                            </div>
                        </div>
                    </div>


                    @error('g-recaptcha-response')
                        <div class="recaptcha-error alert alert-danger d-flex align-items-center mt-2 py-2 px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
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

            <button type="submit" class="login__button" id="submitBtn">Login</button>

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


</body>

</html>
