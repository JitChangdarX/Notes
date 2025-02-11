<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('asset/css/signup.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background-color: black;">
   

    <div class="container mt-5 ">
        <div class="card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="https://img.freepik.com/free-photo/anime-character-traveling_23-2151278765.jpg?t=st=1739029636~exp=1739033236~hmac=62a28331fd5274e645361900a2327a412d7c22c42c194ca8ae39f0c5b4f0b4eb&w=1060"
                        alt="Logo" class="logo-image">
                </div>
                <h2 class="signup-title">Create Your Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('signupaction') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="">name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your name"  autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col">
                                <label for="">email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="enter your email" value="{{ old('email') }}"
                                    autocomplete="off">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="">password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="enter your password" name="password"
                                    autocomplete="off">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="">confirm password</label>
                                <input type="password"
                                    class="form-control @error('confirmpassword') is-invalid @enderror" id="password"
                                    placeholder="confirm your password" name="confirmpassword"
                                    autocomplete="off">
                                @error('confirmpassword')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- show password --}}
                    <div class="form-group" class="text-align-center">
                        <div class="row">
                            <div class="col">
                                <label for="">show password</label>
                                <input type="checkbox" id="showPassword">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-primary" type="submit">Sign Up</button>

                    </div>
                </form>
            </div>
            </form>
        </div>
    </div>
    </div>

</body>

</html>
