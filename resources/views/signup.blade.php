<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="{{ asset('asset/signup.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('asset/css/signup.css') }}">
</head>

<body>
    <nav class="nav-bar">
        <div class="nav-content">
            <div class="nav-logo">
                <span class="logo-icon">📝</span>
                <span class="logo-text">User<span class="highlight">Notes</span></span>
            </div>
            <div class="nav-links">
                <a href="{{ route('signup') }}">Home</a>
                <a href="{{ route('logins') }}">Login</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
    </nav>

    </div>
    <canvas id="particleCanvas"></canvas>
    <canvas id="confettiCanvas"></canvas>
    <div class="container mt-5">
        <div class="card signup-card">
            <div class="card-header text-center">
                <div class="logo-container">
                    <img src="https://img.freepik.com/free-photo/anime-character-traveling_23-2151278765.jpg"
                        alt="Profile picture" class="logo-image" loading="lazy" id="logo">
                </div>
                <h2 class="signup-title">Create Your Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('signupaction') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="return validateAndSubmitForm(event)">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                onkeyup="validateEmail()">
                            <span id="emailError" style="color: red;"></span>

                            {{-- Laravel validation error --}}
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            {{-- Session error from redirect --}}
                            @if (session('error'))
                                <div class="text-danger mt-1">{{ session('error') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter your password"
                                oninput="checkStrength()">
                            <div id="strengthResult" class="mt-1 text-sm"></div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" class="form-control @error('confirmpassword') is-invalid @enderror"
                                id="confirmpassword" name="confirmpassword" placeholder="Confirm your password"
                                disabled>
                            <div id="matchResult" class="mt-1 text-sm text-danger"></div>
                            @error('confirmpassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                        <div id="drop-area"
                            class="relative border-4 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer transition-all duration-300 hover:border-indigo-500 hover:bg-indigo-50">
                            <input type="file" name="profile_photo[]" id="inputGroupFile02" multiple accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                onchange="handleFiles(this.files)">
                            <p class="text-gray-500">Drag & drop images here or <span
                                    class="text-indigo-600 font-semibold">click to select</span></p>
                        </div>
                        <div id="preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4"></div>
                    </div>
                    <div class="form-group text-center mb-3">
                        <input type="checkbox" id="showPassword" onclick="togglePassword()">
                        <label for="showPassword" class="ml-2">Show Password</label>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mb-3">
                        <button class="btn btn-primary" id="myButton" type="submit">Sign Up</button>
                    </div>
                    <div class="text-center mb-4">
                        {{-- {{ route('auth.google') }} --}}
                        <a href="{{ route('auth.google') }}" class="google-signup-btn"
                            aria-label="Sign up with Google">
                            <span class="google-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.21 1.125-.843 2.078-1.797 2.716v2.258h2.908c1.702-1.567 2.685-3.874 2.685-6.615z"
                                        fill="#4285F4" />
                                    <path
                                        d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z"
                                        fill="#34A853" />
                                    <path
                                        d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71s.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.347 3.827.957 5.042h3.007v-2.332z"
                                        fill="#FBBC05" />
                                    <path
                                        d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.958h3.007v2.332C5.672 5.164 7.656 3.58 9 3.58z"
                                        fill="#EA4335" />
                                </svg>
                            </span>
                            <span class="google-text">Continue with Google</span>
                        </a>
                    </div>
                    <div id="dynamicMessage"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="cookie-toggle" id="cookieToggle">
        <svg viewBox="0 0 512 512" fill="currentColor">
            <path
                d="M257.5 27.6c-.8-5.6-6.8-9.3-12.2-7.4-50.5 18-93.9 55.5-121.7 105.9-28 50.4-34.6 110.5-18.9 166.3 5.5 19.9 12.6 38.5 21.1 55.7 10.7 21.6 23.9 41.1 39.9 58.6 4.2 4.5 11.6 4.3 15.7-.3 2.9-3.3 2.8-8.1-.1-11.4-2.5-2.8-4.9-5.7-7.3-8.7-.4-.6-.8-1.2-1.3-1.7-.4-.6-.9-1.2-1.3-1.7-.7-.9-1.3-1.9-1.8-2.9-.5-.8-.9-1.7-1.4-2.5-.5-.8-.9-1.6-1.2-2.2-.4-.7-.7-1.3-1-1.9-.3-.7-.6-1.3-.9-2l-.8-1.8c-.3-.6-.5-1.3-.8-1.9-.2-.6-.5-1.3-.7-1.9-.2-.7-.5-1.4-.7-2.1-.2-.6-.4-1.3-.6-1.9-.3-1-.5-2-.7-3-.2-.9-.4-1.8-.6-2.7-.2-1-.4-2-.5-3-.1-.9-.3-1.8-.4-2.8-.1-1-.2-2-.3-3-.1-.9-.2-1.8-.2-2.7-.1-1-.1-2-.2-3 0-.9-.1-1.8-.1-2.7 0-1 0-2-.1-3 0-.9 0-1.8 0-2.7 0-1 0-2 .1-3 0-.9.1-1.8.1-2.7.1-1 .1-2 .2-3 .1-.9.2-1.8.2-2.7.1-1 .2-2 .3-3 .1-.9.3-1.8.4-2.8.1-1 .3-2 .5-3 .2-.9.4-1.8.6-2.7.2-1 .5-2 .7-3 .2-.6.4-1.3.6-1.9.2-.7.5-1.4.7-2.1.2-.6.5-1.3.7-1.9.3-.6.5-1.3.8-1.9l.8-1.8c.3-.7.6-1.3.9-2 .3-.6.7-1.3 1-1.9.4-.7.8-1.5 1.2-2.2.4-.8.9-1.7 1.4-2.5.6-1 1.2-1.9 1.8-2.9.4-.6.9-1.2 1.3-1.7.4-.6.8-1.2 1.3-1.7 2.4-3 4.8-5.9 7.3-8.7 3-3.3 3-8.1.1-11.4-4.1-4.6-11.5-4.7-15.7-.3-16 17.5-29.1 37-39.9 58.6-8.5 17.2-15.6 35.8-21.1 55.7-15.8 56.3-9.1 116.6 18.9 166.3 27.8 50.2 72.6 86.3 123.1 103.5 0 0 .1 0 .1 0 52.2 17.6 108.8 14.1 158.5-9.8 51.6-24.2 92.7-67.8 115.3-121.5 23.1-54.8 23.5-118.8 1.1-172.4-20.1-47.5-57.1-86.2-104.7-109-2.7-1.3-5.9-1.2-8.6.3-2.7 1.5-4.5 4.2-4.9 7.1-.4 2.9.7 5.8 2.9 7.8 2.5 2.2 5 4.6 7.5 7 3.6 3.5 9.3 3.8 13.4.5 32.3 26.3 54.7 62.5 64.1 103.1 10.1 43.4 4.3 89.4-16.2 128.7-24.2 46.5-66.6 81.4-118.5 97.6-55.4 17.3-114.9 9.5-160.7-21-39.9-26.5-69-65.9-82.3-110.7-15.3-51.8-11.7-108.4 10.1-157.1 1.9-4.3.3-9.5-3.7-11.8-4.1-2.3-9.4-1.3-12.1 2.3-2.3 3.1-4.6 6.4-6.6 9.7-5.1 8.3-9.7 17.3-13.9 27-1.7 4 .2 8.6 4.3 10.5 4.1 1.9 8.9.3 10.8-3.7 3.1-7 6.6-13.7 10.5-20.2 28.9-48.7 76.6-79.9 126.8-88.2 5.4-1.9 8.2-8 6-13.1z" />
            <circle cx="214.5" cy="166.9" r="30.8" />
            <circle cx="297.9" cy="304.4" r="38.9" />
            <circle cx="345.1" cy="198.4" r="23.8" />
        </svg>
    </div>

    <!-- Cookie consent popup -->
    <div class="cookie-consent" id="cookieConsent">
        <div class="cookie-header">
            <div class="cookie-icon">
                <svg viewBox="0 0 512 512" fill="currentColor" color="#fbbc05">
                    <path
                        d="M257.5 27.6c-.8-5.6-6.8-9.3-12.2-7.4-50.5 18-93.9 55.5-121.7 105.9-28 50.4-34.6 110.5-18.9 166.3 5.5 19.9 12.6 38.5 21.1 55.7 10.7 21.6 23.9 41.1 39.9 58.6 4.2 4.5 11.6 4.3 15.7-.3 2.9-3.3 2.8-8.1-.1-11.4-2.5-2.8-4.9-5.7-7.3-8.7-.4-.6-.8-1.2-1.3-1.7-.4-.6-.9-1.2-1.3-1.7-.7-.9-1.3-1.9-1.8-2.9-.5-.8-.9-1.7-1.4-2.5-.5-.8-.9-1.6-1.2-2.2-.4-.7-.7-1.3-1-1.9-.3-.7-.6-1.3-.9-2l-.8-1.8c-.3-.6-.5-1.3-.8-1.9-.2-.6-.5-1.3-.7-1.9-.2-.7-.5-1.4-.7-2.1-.2-.6-.4-1.3-.6-1.9-.3-1-.5-2-.7-3-.2-.9-.4-1.8-.6-2.7-.2-1-.4-2-.5-3-.1-.9-.3-1.8-.4-2.8-.1-1-.2-2-.3-3-.1-.9-.2-1.8-.2-2.7-.1-1-.1-2-.2-3 0-.9-.1-1.8-.1-2.7 0-1 0-2-.1-3 0-.9 0-1.8 0-2.7 0-1 0-2 .1-3 0-.9.1-1.8.1-2.7.1-1 .1-2 .2-3 .1-.9.2-1.8.2-2.7.1-1 .2-2 .3-3 .1-.9.3-1.8.4-2.8.1-1 .3-2 .5-3 .2-.9.4-1.8.6-2.7.2-1 .5-2 .7-3 .2-.6.4-1.3.6-1.9.2-.7.5-1.4.7-2.1.2-.6.5-1.3.7-1.9.3-.6.5-1.3.8-1.9l.8-1.8c.3-.7.6-1.3.9-2 .3-.6.7-1.3 1-1.9.4-.7.8-1.5 1.2-2.2.4-.8.9-1.7 1.4-2.5.6-1 1.2-1.9 1.8-2.9.4-.6.9-1.2 1.3-1.7.4-.6.8-1.2 1.3-1.7 2.4-3 4.8-5.9 7.3-8.7 3-3.3 3-8.1.1-11.4-4.1-4.6-11.5-4.7-15.7-.3-16 17.5-29.1 37-39.9 58.6-8.5 17.2-15.6 35.8-21.1 55.7-15.8 56.3-9.1 116.6 18.9 166.3 27.8 50.2 72.6 86.3 123.1 103.5 0 0 .1 0 .1 0 52.2 17.6 108.8 14.1 158.5-9.8 51.6-24.2 92.7-67.8 115.3-121.5 23.1-54.8 23.5-118.8 1.1-172.4-20.1-47.5-57.1-86.2-104.7-109-2.7-1.3-5.9-1.2-8.6.3-2.7 1.5-4.5 4.2-4.9 7.1-.4 2.9.7 5.8 2.9 7.8 2.5 2.2 5 4.6 7.5 7 3.6 3.5 9.3 3.8 13.4.5 32.3 26.3 54.7 62.5 64.1 103.1 10.1 43.4 4.3 89.4-16.2 128.7-24.2 46.5-66.6 81.4-118.5 97.6-55.4 17.3-114.9 9.5-160.7-21-39.9-26.5-69-65.9-82.3-110.7-15.3-51.8-11.7-108.4 10.1-157.1 1.9-4.3.3-9.5-3.7-11.8-4.1-2.3-9.4-1.3-12.1 2.3-2.3 3.1-4.6 6.4-6.6 9.7-5.1 8.3-9.7 17.3-13.9 27-1.7 4 .2 8.6 4.3 10.5 4.1 1.9 8.9.3 10.8-3.7 3.1-7 6.6-13.7 10.5-20.2 28.9-48.7 76.6-79.9 126.8-88.2 5.4-1.9 8.2-8 6-13.1z" />
                    <circle cx="214.5" cy="166.9" r="30.8" />
                    <circle cx="297.9" cy="304.4" r="38.9" />
                    <circle cx="345.1" cy="198.4" r="23.8" />
                </svg>
            </div>
            <h2 class="cookie-title">Cookie Consent</h2>
        </div>

        <div class="cookie-text">
            We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. By
            clicking "Accept," you consent to our use of cookies for these purposes.
        </div>

        <div class="cookie-buttons">
            <button class="cookie-btn decline-btn" id="declineBtn">Decline</button>
            <button class="cookie-btn accept-btn" id="acceptBtn">Accept</button>
        </div>
    </div>

    <div id="loader">
        <div class="spinner"></div>
    </div>
    <script>
        // function redirectToGoogle() {
        //     $("#loader").show();
        //     $.ajax({
        //         url: "auth.google",
        //         method: 'GET',
        //         success: function(response) {
        //             $("#loader").hide();
        //         }
        //     })
        // }
        const cookieConsent = document.getElementById('cookieConsent');
        const cookieToggle = document.getElementById('cookieToggle');
        const acceptBtn = document.getElementById('acceptBtn');
        const declineBtn = document.getElementById('declineBtn');

        // Show cookie popup automatically after a short delay
        setTimeout(() => {
            showCookieConsent();
        }, 1000);

        // Toggle cookie button pulses until consent is given
        cookieToggle.classList.add('pulse');

        // Show cookie consent popup
        function showCookieConsent() {
            cookieConsent.classList.add('show');
            cookieToggle.style.display = 'none';
        }

        // Hide cookie consent popup
        function hideCookieConsent() {
            cookieConsent.classList.remove('show');
            cookieToggle.style.display = 'flex';
            cookieToggle.classList.remove('pulse'); // Stop pulsing after user interaction
        }

        // Toggle cookie consent when cookie icon is clicked
        cookieToggle.addEventListener('click', () => {
            showCookieConsent();
        });

        // Button click animations and actions
        acceptBtn.addEventListener('click', () => {
            buttonClickAnimation(acceptBtn);
            setTimeout(() => {
                hideCookieConsent();
                // Here you would normally set a cookie to remember the choice
                // console.log('Cookies accepted');
            }, 300);
        });

        declineBtn.addEventListener('click', () => {
            buttonClickAnimation(declineBtn);
            setTimeout(() => {
                hideCookieConsent();
                // Here you would normally set a cookie to remember the choice
                // console.log('Cookies declined');
            }, 300);
        });

        // Button click animation
        function buttonClickAnimation(button) {
            button.classList.add('clicked');
            setTimeout(() => {
                button.classList.remove('clicked');
            }, 300);
        }
    </script>
    <script src="{{ asset('asset/js/signup.js') }}"></script>
</body>

</html>
