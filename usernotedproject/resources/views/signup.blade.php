<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="{{ asset('asset/css/signup.css') }}">
    <script src="{{ asset('asset/js/signup.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
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
                                    placeholder="Enter your name">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror


                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="{{ old('email') }}">
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
                                    id="password" placeholder="Enter your password" name="password">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password"
                                    class="form-control @error('confirmpassword') is-invalid @enderror"
                                    id="confirmpassword" placeholder="Confirm your password" name="confirmpassword">
                                @error('confirmpassword')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Image upload -->
                    <div class="form-group">
                        <label for="inputGroupFile02">Profile Photo</label>
                        <input type="file" class="form-control" name="profile_photo[]" id="inputGroupFile02"
                            multiple>
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
                    <div class="text-center mb-4">
                        <a href="{{ url('/auth/google') }}" class="google-signup-btn" aria-label="Sign up with Google">
                            <span class="google-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.21 1.125-.843 2.078-1.797 2.716v2.258h2.908c1.702-1.567 2.685-3.874 2.685-6.615z" fill="#4285F4"/>
                                    <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
                                    <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71s.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9s.347 3.827.957 5.042h3.007v-2.332z" fill="#FBBC05"/>
                                    <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.958h3.007v2.332C5.672 5.164 7.656 3.58 9 3.58z" fill="#EA4335"/>
                                </svg>
                            </span>
                            <span class="google-text">Continue with Google</span>
                        </a>
                    </div>

                </form>

                <!-- Cookie banner -->
                <div class="cookie-consent">
                    <div class="cookie-icon">
                        <div class="cookie">
                            <div class="chip chip1"></div>
                            <div class="chip chip2"></div>
                            <div class="chip chip3"></div>
                        </div>
                    </div>
                    <div class="cookie-text">
                        We use cookies to optimize your experience and analyze traffic. 
                        Accept cookies to continue or decline for basic functionality.
                    </div>
                    <div class="cookie-buttons">
                        <button class="cookie-btn decline-btn" onclick="declineCookies()">Decline</button>
                        <button class="cookie-btn accept-btn" onclick="acceptCookies()">Accept</button>
                    </div>
                </div>
                <!-- Loader -->
                <div id="loader" style="display: none;">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>


    </div>
    <script src="{{ asset('asset/js/signup.js') }}"></script>
</body>

</html>
