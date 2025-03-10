<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="{{asset('asset/css/login.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{asset('asset/js/login.js')}}"></script>
    <title>Login form-Bedimcode</title>
</head>

<body>
    <div class="login">
        <img src="{{asset('asset/login-bg.png')}}" alt="image" class="login__bg">

        <form action="{{route('loginaction')}}" method="post" class="login__form">
            @csrf
            <h1 class="login__title">Login</h1>

            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" placeholder="Email ID" name="email" required class="login__input" autocomplete="off">
                    <i class="ri-mail-fill"></i>
                </div>
                <div class="login__box">
                    <input type="password" placeholder="Password" name="password" required class="login__input" id="password" autocomplete="off">
                    <i id="eyeIcon" class="ri-eye-off-line" onclick="myFunction()" style="cursor: pointer"></i>
                </div>
            </div>
            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Remember me</label>
                </div>

                <a href="#" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button">Login</button>

            <div class="login__register">
                Don't have an account? <a href="{{route('signup')}}">Register</a>
            </div>
        </form>
    </div>
</body>

</html>
