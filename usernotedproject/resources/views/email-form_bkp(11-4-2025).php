<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Email / OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 5px; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { width: 100%; padding: 10px; background: #28a745; border: none; color: white; font-size: 16px; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .message { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Email / OTP Verification</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div class="message error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- STEP 1: Email Input --}}
        @if(!session('otp_sent'))
            <form method="POST" action="{{ route('otp.send') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Enter Your Email</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
                </div>
                <button class="btn" type="submit">Send OTP</button>
            </form>
        @endif

        {{-- STEP 2: OTP Input --}}
        @if(session('otp_sent'))
            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf
                <div class="input-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" required placeholder="6-digit code">
                </div>
                <button class="btn" type="submit">Verify OTP</button>
            </form>
        @endif
    </div>
</body>
</html>
