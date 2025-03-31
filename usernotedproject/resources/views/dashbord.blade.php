<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="view-transition" content="same-origin">
    <title>dashbord</title>
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
    <script src="{{ asset('asset/js/dashbord.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })

        function toggleSettings() {
            const panel = document.getElementById('settingsPanel');
            const overlay = document.querySelector('.backdrop-overlay');

            panel.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const panel = document.getElementById('settingsPanel');
            const button = document.querySelector('.settings-btn');
            const overlay = document.querySelector('.backdrop-overlay');

            if (!panel.contains(event.target) && event.target !== button) {
                panel.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    </script>

</head>

<body>

    {{-- <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.jpg') }}" 
    alt="Profile Picture" 
    class="rounded-circle" 
    width="50"> --}}


    @php
        use Illuminate\Support\Facades\DB;

        $user = DB::table('signup_account')->where('id', session('user_id'))->first();

        // Ensure $user is not null before accessing properties
        $profilePhotos = $user ? json_decode($user->profile_photo, true) : null;

        // Check if profilePhotos is a valid array and fetch the first image, else set default
        $profilePhoto = is_array($profilePhotos) && !empty($profilePhotos) ? $profilePhotos[0] : 'default-profile.png';
    @endphp






    {{-- @if ($user)
        <p>User ID: {{ $user->id }}</p>
        <p>User Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
    @endif --}}
    <button class="toggle-btn" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>

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

    <!-- Main Content -->
    {{-- <div class="content" id="mainContent">
        <h1>Modern Animated Sidebar</h1>
        <p>Experience smooth animations and modern interactions!</p>
    </div> --}}

    <script>
        function toggleMenu() {
            document.getElementById("sidebar").classList.toggle("active");
            document.querySelector(".toggle-btn").classList.toggle("active");
            document.getElementById("mainContent").classList.toggle("active");
            document.getElementById("backdrop").classList.toggle("active");
        }
    </script>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

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
        {{-- <div class="logo-container">
            <a href="{{ route('dashbord', ['id' => session('user_id')]) }}" class="logo-link">
                <img src="https://www.gstatic.com/images/branding/product/1x/keep_2020q4_48dp.png" alt="Logo"
                    class="logo-image">
            </a>
            <h1 class="logo-title">My Notes</h1>
        </div> --}}

        <a href="#" class="nav-link">
            {{-- <img src="keep-icon.png" alt="Keep Icon" style="width: 20px;"> --}}
            {{-- Keep --}}
        </a>





        <div class="profile-container">
            <div class="profile-header">
                <img src="{{ asset($profilePhoto) }}" class="profile-image" alt="Profile">
                <span class="profile-name">{{ $user->name }}</span>
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
                    $encryptedId = Crypt::encryptString($user->id);
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


        {{-- <div class="searchbox">
            <form action="" method="POST" class="search-box">
                @csrf
                <input type="text" placeholder="Search...">
            </form>
        </div> --}}
    </div>

    {{-- setting --}}

    <div class="settings-panel" id="settingsPanel">
        <i class="ri-close-fill" onclick="toggleSettings()" id="close"></i>
        <h2>Settings</h2>
        <div class="settings-options">
            <button><i class="ri-settings-4-fill"></i> General</button>
            <button><i class="ri-user-heart-fill"></i> Personalization</button>
            <button><i class="ri-apps-2-line"></i> Connected Apps</button>
            <button><i class="ri-lock-password-fill"></i> Privacy</button>
            <button><i class="ri-notification-3-fill"></i> Notifications</button>
        </div>
        <button class="close-btn" onclick="toggleSettings()">Close</button>
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



</body>

</html>
