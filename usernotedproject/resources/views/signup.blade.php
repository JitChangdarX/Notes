<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('asset/css/signup.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                                <input type="text" class="form-control" id="name" placeholder="enter your name"
                                    required autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="">email</label>
                                <input type="email" class="form-control" id="email" placeholder="enter your email"
                                    required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="">password</label>
                                <input type="password" class="form-control" id="password"
                                    placeholder="enter your password" required autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="">confirm password</label>
                                <input type="password" class="form-control" id="password"
                                    placeholder="confirm your password" required autocomplete="off">
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
