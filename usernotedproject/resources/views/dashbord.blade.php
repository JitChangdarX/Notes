<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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


    {{-- // create a logo logout my profile my notes --}}
    {{-- check screenshoet --}}
    {{-- create light and dark theme --}}

    {{-- create a nav bar --}}

    {{-- @php
        use App\Models\SignupAccount; // Correct model name

        $users = SignupAccount::all(); // Fetch all rows from `signup_account` table

        foreach ($users as $user) {
            echo $user->name; // Display column values
        }
    @endphp --}}

    @php
        $user = DB::table('signup_account')->where('id', session('user_id'))->first();
        $profilePhotos = json_decode($user->profile_photo, true);
        $profilePhoto = is_array($profilePhotos) ? $profilePhotos[0] : $profilePhotos;
    @endphp

    @if ($user)
        <p>User ID: {{ $user->id }}</p>
        {{-- <p>User Name: {{ $user->name }}</p> --}}
        <p>Email: {{ $user->email }}</p>
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
        <div class="logo-container">
            <div class="logo">
                <a href="{{ route('dashbord', ['id' => session('user_id')]) }}">
                    <img src="https://www.gstatic.com/images/branding/product/1x/keep_2020q4_48dp.png" alt="Logo">


                </a>
                <h1>My Notes</h1>


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
                        <div class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa-solid fa-envelope"></i> Contact Us
                        </div>

                        <div class="dropdown-item">
                            <i class="ri-logout-circle-r-line"></i> Logout
                        </div>
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
        </div>

        <div class="searchbox">
            <form action="" method="get" class="search-box">
                <input type="text" placeholder="Search...">
            </form>
        </div>
    </div>

    {{-- setting --}}

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


    {{-- {{ create a div  multiple div }} --}}
    <div class="container">
        <div class="parent">
            <div class="div1">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>


            <div class="div2">
                <input type="text" contenteditable="true">
                <input type="text" class="custom-input" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>
            <div class="div3">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>

            <div class="div4">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
                <input type="text" contenteditable="true">
            </div>
        </div>
    </div>
</body>

</html>
