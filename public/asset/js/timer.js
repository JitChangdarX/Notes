document.addEventListener('DOMContentLoaded', function () {
    console.log('DOMContentLoaded fired');
    const otpForm = document.querySelector('#otp-form');
    console.log('OTP form:', otpForm);
    console.log('Is active:', otpForm?.classList.contains('active'));
    if (otpForm && otpForm.classList.contains('active')) {
        console.log('Starting OTP timer');
        startOtpTimer();
    } else {
        console.log('OTP form not active');
    }
});

function startOtpTimer() {
    console.log('startOtpTimer called');
    const timerDisplay = document.querySelector('#timer');
    const resendBtn = document.querySelector('#resend-btn');
    let timeLeft = 600; // 10 minutes in seconds

    // Check stored time
    const storedStartTime = localStorage.getItem('otpTimerStart');
    if (storedStartTime) {
        const elapsed = Math.floor((Date.now() - storedStartTime) / 1000);
        timeLeft = Math.max(0, 600 - elapsed);
        console.log('Stored time found:', { storedStartTime, elapsed, timeLeft });
    } else {
        localStorage.setItem('otpTimerStart', Date.now());
        console.log('New timer started');
    }

    resendBtn.disabled = true;

    const timerInterval = setInterval(() => {
        console.log('Timer tick:', timeLeft);
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerDisplay.textContent = '00:00';
            resendBtn.disabled = false;
            localStorage.removeItem('otpTimerStart');
            console.log('Timer finished');
            return;
        }

        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        timeLeft--;
    }, 1000);
}