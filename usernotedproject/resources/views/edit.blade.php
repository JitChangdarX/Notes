<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit profile</title>
    <link rel="stylesheet" href="{{ asset('asset/css/edit.css') }}">
</head>
<body>

    @php
    use Illuminate\Support\Facades\DB;
    $user = DB::table('signup_account')->where('id', session('user_id'))->first();

    $profilePhotos = $user ? json_decode($user->profile_photo, true) : null;
    $profilePhoto = is_array($profilePhotos) && !empty($profilePhotos) ? $profilePhotos[0] : 'default-profile.png';
@endphp


    <div class="cursor" id="cursor"></div>
    <canvas id="bg-canvas"></canvas>
    <div class="container">
        <div class="profile-header magnetic">
            <div class="photo-frame"></div>
            <img src="{{ asset($profilePhoto) }}" class="profile-image" alt="Profile">
            <h2>Edit Profile</h2>
        </div>

        <form id="editForm">
            <div class="form-group magnetic">
                <label for="name">Full Name</label>
                <input type="text" id="name" required>
                <div class="input-line"></div>
            </div>

            <div class="form-group magnetic">
                <label for="email">Email</label>
                <input type="email" id="email" required>
                <div class="input-line"></div>
            </div>

            <div class="form-group magnetic">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                    <div class="input-line"></div>
                </div>
            </div>

            <div class="form-group magnetic">
                <label for="photo">Profile Photo</label>
                <input type="file" id="photo" accept="image/*" onchange="previewImage(event)">
                <div class="input-line"></div>
            </div>

            <button type="submit" class="btn magnetic">Update Profile</button>
        </form>

        <div class="success-message" id="successMessage">
            Profile Updated Successfully!
        </div>
    </div>

    <script>
        // Modern Gradient Wave Background
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const waves = [];
        const gradientColors = [
            ['#ff6b6b', '#4ecdc4'],
            ['#45b7d1', '#96c93d'],
            ['#f7d794', '#f94144']
        ];

        class Wave {
            constructor() {
                this.y = Math.random() * canvas.height;
                this.amplitude = Math.random() * 50 + 20;
                this.frequency = Math.random() * 0.01 + 0.005;
                this.speed = Math.random() * 0.5 + 0.2;
                this.phase = Math.random() * Math.PI * 2;
                this.colors = gradientColors[Math.floor(Math.random() * gradientColors.length)];
            }

            update(time) {
                this.phase += this.speed * 0.01;
            }

            draw() {
                const gradient = ctx.createLinearGradient(0, this.y - this.amplitude, 0, this.y + this.amplitude);
                gradient.addColorStop(0, this.colors[0]);
                gradient.addColorStop(1, this.colors[1]);

                ctx.beginPath();
                ctx.moveTo(0, this.y);
                for (let x = 0; x < canvas.width; x++) {
                    const y = this.y + Math.sin(x * this.frequency + this.phase) * this.amplitude;
                    ctx.lineTo(x, y);
                }
                ctx.strokeStyle = gradient;
                ctx.lineWidth = 2;
                ctx.globalAlpha = 0.4;
                ctx.stroke();

                // Fill the wave with a subtle gradient
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.closePath();
                ctx.fillStyle = gradient;
                ctx.globalAlpha = 0.1;
                ctx.fill();
            }
        }

        function init() {
            for (let i = 0; i < 5; i++) {
                waves.push(new Wave());
            }
        }

        let time = 0;
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            time++;

            waves.forEach(wave => {
                wave.update(time);
                wave.draw();
            });

            requestAnimationFrame(animate);
        }

        init();
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            waves.length = 0;
            init();
        });

        // Custom Cursor
        const cursor = document.getElementById('cursor');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        document.querySelectorAll('.magnetic').forEach(elem => {
            elem.addEventListener('mousemove', (e) => {
                const rect = elem.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const distX = (e.clientX - centerX) / 20;
                const distY = (e.clientY - centerY) / 20;
                elem.style.transform = `translate(${distX}px, ${distY}px)`;
                cursor.classList.add('grow');
            });

            elem.addEventListener('mouseleave', () => {
                elem.style.transform = '';
                cursor.classList.remove('grow');
            });
        });

        // Form Functions
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profilePhoto');
                output.src = reader.result;
                output.style.transform = 'scale(1.15)';
                setTimeout(() => output.style.transform = 'scale(1)', 300);
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.animation = 'popIn 0.5s ease reverse';
                setTimeout(() => successMessage.style.display = 'none', 500);
            }, 3000);
        });
    </script>
</body>
</html>