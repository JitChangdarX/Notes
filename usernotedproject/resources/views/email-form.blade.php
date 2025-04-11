<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Email / OTP</title>
    <link rel="stylesheet" href="{{ asset('asset/css/email.css') }}">
</head>

<body>

    <!-- Progress bar -->
    <div class="progress-wrapper">
        <div class="progress-bar">
            <div class="step {{ session('otp_sent') ? 'completed' : 'active' }}">1</div>
            <div class="line {{ session('otp_sent') ? 'filled' : '' }}"></div>
            <div class="step {{ session('otp_sent') ? 'active' : '' }}">2</div>
        </div>
        <div class="progress-labels">
            <span>Email</span>
            <span>OTP</span>
        </div>
    </div>

    <!-- Main container -->
    <div class="container">
        <h2>Forgot Email / OTP Verification</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="message error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- STEP 1: Email Input --}}
        @if (!session('otp_sent'))
            <div id="email-form">
                <form method="POST" action="{{ route('otp.send') }}" onsubmit="return validateEmailForm(event)">
                    @csrf
                    <div class="input-group">
                        <label for="email">Enter Your Email</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com"
                            value="{{ old('email') }}">
                        <div class="error-message">Please enter a valid email address</div>
                    </div>
                    <button class="btn" type="submit">Send OTP</button>
                </form>
            </div>
        @endif

        {{-- STEP 2: OTP Input --}}
        @if (session('otp_sent'))
            <div id="otp-form">
                <form method="POST" action="{{ route('otp.verify') }}" onsubmit="return validateOtpForm(event)">
                    @csrf
                    <div class="input-group">
                        <label>Enter OTP</label>
                        <div class="otp-inputs">
                            <input type="text" maxlength="1" class="otp-box" onpaste="handlePaste(event)">
                            <input type="text" maxlength="1" class="otp-box">
                            <input type="text" maxlength="1" class="otp-box">
                            <input type="text" maxlength="1" class="otp-box">
                            <input type="text" maxlength="1" class="otp-box">
                            <input type="text" maxlength="1" class="otp-box">
                        </div>
                        <input type="hidden" id="otp" name="otp">
                        <div class="error-message">Please enter a valid 6-digit OTP</div>
                    </div>
                    <button class="btn" type="submit">Verify OTP</button>
                </form>
            </div>
        @endif
    </div>

    <script>
        function validateEmailForm(event) {
            const emailInput = document.getElementById('email');
            const email = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                event.preventDefault();
                emailInput.classList.add('error');
                return false;
            }

            emailInput.classList.remove('error');
            return true;
        }

        function validateOtpForm(event) {
            const otpBoxes = document.querySelectorAll('.otp-box');
            let otp = '';
            otpBoxes.forEach(box => otp += box.value);

            const otpRegex = /^\d{6}$/;
            if (!otpRegex.test(otp)) {
                event.preventDefault();
                otpBoxes.forEach(box => box.classList.add('error'));
                document.querySelector('#otp-form .error-message').style.display = 'block';
                return false;
            }

            document.getElementById('otp').value = otp;
            otpBoxes.forEach(box => box.classList.remove('error'));
            document.querySelector('#otp-form .error-message').style.display = 'none';
            return true;
        }

        // OTP Box Navigation
        document.querySelectorAll('.otp-box').forEach((box, index) => {
            box.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < 5) {
                    document.querySelectorAll('.otp-box')[index + 1].focus();
                }
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
            });

            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    document.querySelectorAll('.otp-box')[index - 1].focus();
                }
            });
        });

        // Handle OTP Paste
        function handlePaste(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            if (paste.length === 6) {
                const otpBoxes = document.querySelectorAll('.otp-box');
                paste.split('').forEach((char, index) => {
                    otpBoxes[index].value = char;
                });
                otpBoxes[5].focus();
            }
        }

        // Clear error on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('error');
                const errorMessage = input.parentElement.querySelector('.error-message');
                if (errorMessage) errorMessage.style.display = 'none';
            });
        });
    </script>
</body>

</html>