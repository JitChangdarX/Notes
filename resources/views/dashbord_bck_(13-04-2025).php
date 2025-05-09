<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="view-transition" content="same-origin">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
    <script src="{{ asset('asset/js/dashbord.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <style>
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    @php
        use Illuminate\Support\Facades\DB;

        $user = DB::table('signup_account')->where('id', session('user_id'))->first();

        $profilePhotos = $user ? json_decode($user->profile_photo, true) : null;

        $profilePhoto = is_array($profilePhotos) && !empty($profilePhotos) ? $profilePhotos[0] : 'default-profile.png';

    @endphp







    <button class="toggle-btn" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <nav class="sidebar" id="sidebar">
        <ul>
            <li><a href="{{ url('/dashbord') }}">🏠 Home</a></li>
            <li><a href="#about">👤 About</a></li>
            <li><a href="#services">🛠 Services</a></li>
            <li><a href="#portfolio">📁 Portfolio</a></li>
            <li>
                <a href="javascript:void(0)" style="text-decoration: none" onclick="openContactModal()"
                    class="contact-link">📧 Contact</a>
            </li>
        </ul>
    </nav>
    <div class="backdrop" id="backdrop" onclick="toggleMenu()"></div>

    <script>
        function toggleMenu() {
            document.getElementById("sidebar").classList.toggle("active");
            document.querySelector(".toggle-btn").classList.toggle("active");
            document.getElementById("mainContent").classList.toggle("active");
            document.getElementById("backdrop").classList.toggle("active");
        }
    </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

    {{-- contact use modal pop up --}}



    <div class="header">
        <a href="#" class="nav-link">
        </a>

        <div class="profile-container">
            <div class="profile-header">
                <img src="{{ asset($profilePhoto) }}" class="profile-image" alt="Profile">
                <span class="profile-name">{{ Auth::user()->name }}</span>

                <span class="dropdown-icon">▼</span>
            </div>

            <div class="profile-dropdown">

                <div class="settings-btn" onclick="toggleSettings()">
                    <i class="ri-settings-3-fill"></i>Settings
                </div>
                <div class="backdrop-overlay"></div>
                <div class="dropdown-item delete-btn">
                    <i class="ri-delete-bin-5-line"></i>Delete Chat History
                </div>
                @php
                    use Illuminate\Support\Facades\Crypt;
                    use Illuminate\Support\Facades\Auth;

                    $authUser = Auth::user();
                    $encryptedId = $authUser ? Crypt::encryptString($authUser->id) : null;
                @endphp


                <a href="{{ route('edit_profile', ['id' => $encryptedId]) }}" class="dropdown-item btn btn-primary">
                    <i class="ri-pencil-line"></i> Edit Profile
                </a>


                <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ri-logout-circle-r-line"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>
        <script>
            const profileHeader = document.querySelector('.profile-header');
            const profileDropdown = document.querySelector('.profile-dropdown');

            profileHeader.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
                profileHeader.classList.toggle('active');
            });

            document.addEventListener('click', () => {
                profileDropdown.classList.remove('active');
                profileHeader.classList.remove('active');
            });

            document.querySelector('.delete-btn').addEventListener('click', () => {
                const confirmDelete = confirm('Are you sure you want to delete all chat history?');
                if (confirmDelete) {
                    document.querySelectorAll('.chat-item').forEach(item => item.remove());
                    profileDropdown.classList.remove('active');
                }
            });

            document.querySelectorAll('.dropdown-item').forEach(item => {
                if (!item.classList.contains('delete-btn')) {
                    item.addEventListener('click', () => {
                        // alert('Settings clicked');
                        profileDropdown.classList.remove('active');
                    });
                }
            });
        </script>
        <div id="showdiv"></div>



    </div>

    {{-- setting --}}

    <div class="settings-panel" id="settingsPanel">
        <i class="ri-close-fill" onclick="toggleSettings()" id="close"></i>
        <h2>Settings</h2>
        <div class="settings-options">
            <button onclick="window.location.href = '{{ route('general_setting') }}';"><i
                    class="ri-settings-4-fill"></i> General</button>
            <button id="theme-switch">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                    <path
                        d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                    <path
                        d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z" />
                </svg>
            </button>

            <button><i class="ri-user-heart-fill"></i> Personalization</button>
            <button><i class="ri-apps-2-line"></i> Connected Apps</button>
            <button><i class="ri-lock-password-fill"></i> Privacy</button>
            <button><i class="ri-notification-3-fill"></i> Notifications</button>
        </div>
        <button class="close-btn" onclick="toggleSettings()">Close</button>
        <canvas id="confetti-canvas"></canvas>
    </div>


    {{-- {{ create a div  multiple div }} --}}
    <div class="container">
        <div class="parent">
            <div class="div1">
                <input type="text" placeholder="Note 1">
                <input type="text" placeholder="Note 2">
                <input type="text" placeholder="Note 3">
                <input type="text" placeholder="Note 4">
            </div>

            <div class="div2">
                <input type="text" placeholder="Note 5">
                <input type="text" class="custom-input" placeholder="Note 6">
                <input type="text" placeholder="Note 7">
                <input type="text" placeholder="Note 8">
            </div>

            <div class="div3">
                <input type="text" placeholder="Note 9">
                <input type="text" placeholder="Note 10">
                <input type="text" placeholder="Note 11">
                <input type="text" placeholder="Note 12">
            </div>

            <div class="div4">
                <input type="text" placeholder="Note 13">
                <input type="text" placeholder="Note 14">
                <input type="text" placeholder="Note 15">
                <input type="text" placeholder="Note 16">
            </div>
        </div>
    </div>
    {{-- -> <- handle for secure page i was commentout this part --}}

    {{-- final version --}}
    <script>
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    </script>


    <script>
        const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
        const themeToggle = document.getElementById('theme-switch');
        const savedTheme = localStorage.getItem('theme');

        function applyTheme(isDark) {
            document.documentElement.style.setProperty('--background', isDark ? '#0f172a' : '#ffffff');
            document.documentElement.style.setProperty('--surface-color', isDark ? '#1e293b' : '#f1f5f9');
            document.documentElement.style.setProperty('--text-color', isDark ? '#f8fafc' : '#1e293b');
            document.body.style.background = isDark ? '#0f172a' : '#ffffff'; // Directly updating body background
        }


        function updateToggleIcon(isDark) {
            themeToggle.textContent = isDark ? '🌙' : '☀️';
        }

        if (savedTheme) {
            const isDark = savedTheme === 'dark';
            applyTheme(isDark);
            updateToggleIcon(isDark);
        } else {
            applyTheme(systemDarkMode.matches);
            updateToggleIcon(systemDarkMode.matches);
        }

        systemDarkMode.addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
                updateToggleIcon(e.matches);
            }
        });

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.style.getPropertyValue('--background') === '#0f172a';
            const newTheme = !isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme(!isDark);
            updateToggleIcon(!isDark);
        });

        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') {
                const isDark = e.newValue === 'dark';
                applyTheme(isDark);
                updateToggleIcon(isDark);
            }
        });
    </script>



    <script>
        const canvas = document.getElementById('confetti-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        function createParticle() {
            return {
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: Math.random() * 4 + 1,
                color: `hsl(${Math.random() * 360}, 70%, 60%)`,
                speedX: Math.random() * 2 - 1,
                speedY: Math.random() * 2 + 1,
            };
        }

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < particles.length; i++) {
                const p = particles[i];
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.fill();
                p.x += p.speedX;
                p.y += p.speedY;

                // Reset particles when off screen
                if (p.y > canvas.height) {
                    particles[i] = createParticle();
                    particles[i].y = 0;
                }
            }
            requestAnimationFrame(drawParticles);
        }

        window.addEventListener('resize', () => {
            resizeCanvas();
        });

        // Init
        resizeCanvas();
        for (let i = 0; i < 120; i++) {
            particles.push(createParticle());
        }
        drawParticles();
    </script>



</body>

</html>
