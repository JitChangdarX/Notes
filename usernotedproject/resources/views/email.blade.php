<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password - Site Zoon</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{asset('asset/images/favicon.png')}}">

    <link rel="stylesheet" href="{{asset('asset/css/bootstrapmin.css')}}">
    <link rel="stylesheet" href="{{asset('asset/css/email.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 text-center">
                <img src="{{asset('asset/images/main.png')}}" alt="Main IMG" class="img-fluid">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 pt-5">
                <h2 class="main-text pt-5 mt-5">Forgot <br> Your Password</h2>
                <input type="e-mail" placeholder="Enter Your E-mail" class="form-control main-input mt-5">
                <div class="row">
                    <div class="col-3">
                        <button class="btn btn-sz-primary mt-5">Reset</button>
                    </div>
                    <div class="col-6 pt-5">
                        <a href="{{route('login')}}" class="btn btn-primary back-to-login">
                            🔙 Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap5.js"></script>
</html>