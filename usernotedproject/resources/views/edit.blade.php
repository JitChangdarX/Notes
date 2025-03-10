<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="{{ asset('asset/css/edit.css') }}">
</head>

<body>
    @if(isset($user))
        @php
            $profilePhotos = json_decode($user->profile_photo, true);
            $profilePhoto = is_array($profilePhotos) ? $profilePhotos[0] : $profilePhotos;
        @endphp
    @endif

    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <ul>
            <li><a href="{{ url('/signup') }}">🏠 Home</a></li>
            <li><a href="#about">👤 About</a></li>
            <li><a href="#services">🛠 Services</a></li>
            <li><a href="#portfolio">📁 Portfolio</a></li>
            <li data-toggle="modal" data-target="#exampleModal">
                <a href="#contact">📧 Contact</a>
            </li>
        </ul>
    </nav>

    <!-- Backdrop -->
    <div class="backdrop" id="backdrop" onclick="toggleMenu()"></div>

    <script>
        function toggleMenu() {
            document.getElementById("sidebar").classList.toggle("active");
            document.querySelector(".toggle-btn").classList.toggle("active");
            document.getElementById("backdrop").classList.toggle("active");
        }
    </script>

</body>
</html>
