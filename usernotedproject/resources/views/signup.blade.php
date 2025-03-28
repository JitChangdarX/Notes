<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="{{ asset('asset/css/signup.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
</head>

<body>
    <div class="container mt-5">
        <div class="card signup-card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="https://img.freepik.com/free-photo/anime-character-traveling_23-2151278765.jpg?t=st=1739029636~exp=1739033236~hmac=62a28331fd5274e645361900a2327a412d7c22c42c194ca8ae39f0c5b4f0b4eb&w=1060"
                        alt="Profile picture" class="logo-image" id="logo">
                </div>
                <h2 class="signup-title">Create Your Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('signupaction') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your name" autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror


                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="{{ old('email') }}" autocomplete="off">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Enter your password" name="password" autocomplete="off">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password"
                                    class="form-control @error('confirmpassword') is-invalid @enderror"
                                    id="confirmpassword" placeholder="Confirm your password" name="confirmpassword"
                                    autocomplete="off">
                                @error('confirmpassword')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Image upload -->
                    <div class="form-group">
                        <label for="inputGroupFile02">Profile Photo</label>
                        <input type="file" class="form-control" name="profile_photo[]" id="inputGroupFile02" multiple
                            required>
                    </div>

                    <!-- Show password -->
                    <div class="form-group text-center">
                        <input type="checkbox" id="showPassword" onclick="show()">
                        <label for="showPassword">Show Password</label>
                    </div>

                    <!-- Sign Up Button -->
                    <div class="d-grid gap-2 col-6 mx-auto mb-3">
                        <button class="btn btn-primary" type="submit" id="myButton">Sign Up</button>
                    </div>



                    <!-- Sign up with Google -->
                    <div class="text-center mb-3">
                        <a href="{{ url('/auth/google') }}" class="google-signup" aria-label="Sign up with Google">
                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo"
                                width="20">
                            Sign up with Google
                        </a>
                    </div>

                </form>

                <!-- Cookie banner -->
                <div id="cookie-banner-wrapper">
                    <div id="cookie-banner" role="dialog" aria-label="Cookie Consent Banner">
                        <img src="{{ asset('asset/cookie.gif') }}" alt="Cookie Image" class="cookie-image">
                       
                        <div class="cookie-content">
                            <i class="fas fa-cookie-bite cookie-icon" aria-hidden="true"></i>
                            <p>We use cookies to improve your experience. <a href="#" class="learn-more">Learn more</a>.</p>
                            <div class="button-group">
                                <button onclick="acceptCookies()" class="accept-btn">Accept</button>
                                <button onclick="closeBanner()" class="decline-btn">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loader -->
                <div id="loader" style="display: none;">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
       
    
    </div>

    
    <!-- JavaScript -->
    <script>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/get-cookies') // Fetch the cookie from Laravel
                .then(response => response.json())
                .then(data => {
                    if (!data.user_accepted_cookies) {
                        document.getElementById("cookie-banner").style.display = "block";
                    }
                })
                .catch(error => console.error("Error fetching cookies:", error));
        });

        function acceptCookies() {
            fetch('/accept-cookies', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(() => {
                    document.getElementById("cookie-banner").style.display = "none";
                })
                .catch(error => console.error("Error setting cookie:", error));
        }

        function deleteCookies() {
            fetch('/delete-cookies')
                .then(response => response.json())
                .then(() => {
                    alert("Cookies deleted successfully.");
                    document.getElementById("cookie-banner").style.display = "block";
                })
                .catch(error => console.error("Error deleting cookie:", error));
        }

        function declineCookies() {
            document.getElementById('overlay').style.display = 'none';
        }

        function closeBanner() {
            document.getElementById('cookie-banner').style.display = 'none';
        }

    </script>
    <script src="{{ asset('asset/js/signup.js') }}"></script>
</body>

</html>
