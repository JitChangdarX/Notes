<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <title>Settings Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .settings-btn {
            scrollbar-color: var(--main-surface-tertiary);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .settings-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            background: #262222;
            color: white;
            border-radius: 15px;
            padding: 20px;
            width: 47rem;
            height: 38rem;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .settings-panel.active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .settings-panel h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        .settings-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .settings-options button {
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            color: white;
            font-size: 16px;
            padding: 10px;
            cursor: pointer;
            text-align: left;
            width: 100%;
        }

        .settings-options button i {
            margin-right: 10px;
            font-size: 20px;
        }

        .close-btn {
            background-color: red;
            border: none;
            color: white;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin: 10px auto 0;
        }
    </style>
</head>

<body>

    <!-- Settings Button -->
    <button class="settings-btn" onclick="toggleSettings()">⚙ Open Settings</button>

    <!-- Settings Panel -->
    <div class="settings-panel" id="settingsPanel">
        <h2>Settings</h2>
        <div class="settings-options">
            <button><i class="ri-settings-4-fill"></i> General</button>
            <button><i class="ri-user-heart-fill"></i> Personalization</button>
            <button><i class="ri-apps-2-line"></i> Connected Apps</button>
            <button><i class="ri-lock-password-fill"></i> Privacy</button>
            <button><i class="ri-notification-3-fill"></i> Notifications</button>
            <button><i class="ri-logout-box-r-line"></i> Logout</button>
        </div>
        <button class="close-btn" onclick="toggleSettings()">Close</button>
    </div>

    <script>
        function toggleSettings() {
            let panel = document.getElementById('settingsPanel');
            panel.classList.toggle('active');
        }

        // Close panel when clicking outside
        document.addEventListener('click', function(event) {
            let panel = document.getElementById('settingsPanel');
            let button = document.querySelector('.settings-btn');
            if (!panel.contains(event.target) && event.target !== button) {
                panel.classList.remove('active');
            }
        });
    </script>

</body>

</html>
